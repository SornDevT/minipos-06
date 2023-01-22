<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Transection;
use Intervention\Image\Facades\Image;

class StoreController extends Controller
{
    //
    public function add(Request $request){
       try {

            if($request->file('file')){

                $upload_path = "assets/img";
                $generate_new_name = time().'.'.$request->file->getClientOriginalExtension();
                $image = $request->file('file');
                $img = Image::make($image->getRealpath());
                $img->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                });

                $img->save($upload_path.'/'.$generate_new_name);

            } else {
                $generate_new_name = '';
            }

            

            $store = new Store();
            $store->name = $request->name;
            $store->image = $generate_new_name;
            $store->amount = $request->amount;
            $store->price_buy = $request->price_buy;
            $store->price_sell = $request->price_sell;
            $store->save();
            // ດຶງ id ທີ່ບັນທຶກລ່າສຸດອອກມາ
            $product_id = $store->id;


            /// ບັນທຶກ ລາຍຈ່າຍ ຊື້ສິນຄ້າ

                $number = 1;
                $tran = Transection::all()->sortByDesc('id')->take(1)->toArray();

                foreach($tran as $new){
                    $number = $new["tran_id"];
                }
                // ຕົວຢ່າງ INC00001
                if($number !=''){
                    $number1 = str_replace("INC","",$number); // 00001
                    $number2 = str_replace("EXP","",$number1);
                    $number3 = (int)$number2+1; // 1+1 = 2
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00010
                }

                if($request->acc_type == "income") {
                    $tnum = "INC"; //INC00010
                } elseif($request->acc_type == "expense") {
                    $tnum = "EXP"; // EXP00010
                }

                $tran = new Transection();
                $tran->tran_id = $tnum.$number;
                $tran->product_id = $product_id;
                $tran->tran_type = $request->acc_type;
                $tran->amount = $request->amount;
                $tran->tran_detail = " ນຳເຂົ້າສິນຄ້າໃໝ່ ".$request->name;
                $tran->price = $request->amount*$request->price_buy;
                $tran->save();



            $success = true;
            $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";
        
       } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
       }

       $response = [
            "success"=> $success,
            "message"=>$message
       ];

       return response()->json($response);


    }

    public function index(){

        // $store = Store::orderBy('id','asc')
        // ->get();
        // return $store;

        $search = \Request::get('search');

        $store = Store::orderBy('id','desc')
        ->where('name','LIKE',"%{$search}%")
        // ->orWhere('price_buy','LIKE',"%{$search}%")
        // ->orWhere('id','LIKE',"%{$search}%")
        ->paginate(15)
        ->toArray();

        return array_reverse($store);
    }

    public function edit($id){

        $store = Store::find($id);

        return $store; 
    }

    public function update($id, Request $request){

        try {

        $store = Store::find($id);
        $upload_path = "assets/img";

        if($request->file('file')){

            

            // ກວດຊອບ ລຶບຮູບເກົ່າ
            if($store->image!=''){
                if(file_exists($upload_path.'/'.$store->image)){
                    unlink($upload_path.'/'.$store->image);
                }
            }

            //return $request->file('file');


            $generate_new_name = time().'.'.$request->file->getClientOriginalExtension();
            $image = $request->file('file');
            $img = Image::make($image->getRealpath());
            $img->resize(800, null, function($constraint){
                $constraint->aspectRatio();
            });

            $img->save($upload_path.'/'.$generate_new_name);

            $store->update([
                'name'=>$request->name,
                'image'=>$generate_new_name,
                'amount'=>$request->amount,
                'price_buy'=>$request->price_buy,
                'price_sell'=>$request->price_sell,
            ]);

        } else {
           

            // return $request->file;

            if($request->file){
                $store->update([
                    'name'=>$request->name,
                    'amount'=>$request->amount,
                    'price_buy'=>$request->price_buy,
                    'price_sell'=>$request->price_sell,
                ]);
            } else {

                $generate_new_name = '';
                 // ກວດຊອບ ລຶບຮູບເກົ່າ
                if($store->image!=''){
                    if(file_exists($upload_path.'/'.$store->image)){
                        unlink($upload_path.'/'.$store->image);
                    }
                }

                $store->update([
                    'name'=>$request->name,
                    'image'=>$generate_new_name,
                    'amount'=>$request->amount,
                    'price_buy'=>$request->price_buy,
                    'price_sell'=>$request->price_sell,
                ]);

            }

           
        }

       

        $success = true;
        $message = "ອັບເດດຂໍ້ມູນສຳເລັດ!";
    
        } catch (\Illuminate\Database\QueryException $ex) {
                $success = false;
                $message = $ex->getMessage();
        }

        $response = [
                "success"=> $success,
                "message"=>$message
        ];

        return response()->json($response);

    }

    public function delete($id){

        try {

            $store = Store::find($id);

            $upload_path = "assets/img";

            // ກວດຊອບ ລຶບຮູບເກົ່າ
            if($store->image!=''){
                if(file_exists($upload_path.'/'.$store->image)){
                    unlink($upload_path.'/'.$store->image);
                }
            }



            $store->delete();
 
            $success = true;
            $message = "ລຶບຂໍ້ມູນສຳເລັດ!";
        
            } catch (\Illuminate\Database\QueryException $ex) {
                    $success = false;
                    $message = $ex->getMessage();
            }
    
            $response = [
                    "success"=> $success,
                    "message"=>$message
            ];
    
            return response()->json($response);

    }
}
