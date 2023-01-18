<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Store;
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

        $store = Store::orderBy('id','asc')
        ->where('name','LIKE',"%{$search}%")
        // ->orWhere('price_buy','LIKE',"%{$search}%")
        // ->orWhere('id','LIKE',"%{$search}%")
        ->paginate(5)
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

        if($request->file('file')){

            $upload_path = "assets/img";

            // ກວດຊອບ ລຶບຮູບເກົ່າ
            if($store->image!=''){
                if(file_exists($upload_path.'/'.$store->image)){
                    unlink($upload_path.'/'.$store->image);
                }
            }


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
            $generate_new_name = '';

            $store->update([
                'name'=>$request->name,
                'amount'=>$request->amount,
                'price_buy'=>$request->price_buy,
                'price_sell'=>$request->price_sell,
            ]);
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
