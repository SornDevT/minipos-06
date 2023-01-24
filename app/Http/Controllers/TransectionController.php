<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Store;
use App\Models\Bill;
use App\Models\Bill_list;

class TransectionController extends Controller
{
    //

    public function index(Request $request){

        $month_type = $request->month_type;
        $dmy = $request->dmy;

        if($dmy == ''){

            $tran = Transection::orderBy("created_at","desc")
            ->paginate(10)
            ->toArray();
            return array_reverse($tran);

        } else {

            $m = explode("-",$dmy)[1];
            $y = explode("-",$dmy)[0];

            if($month_type == "m"){

                //  return $m;

                $tran = Transection::orderBy("created_at","desc")
                ->whereYear("created_at","=",$y)
                ->whereMonth("created_at","=",$m)
                ->paginate(10)
                ->toArray();
                return array_reverse($tran);

            } else if($month_type == "y"){

                $tran = Transection::orderBy("created_at","desc")
                ->whereYear("created_at","=",$y)
                ->paginate(10)
                ->toArray();
                return array_reverse($tran);

            }

        }

    }

    public function add(Request $request){
        try {


            // ຂໍ້ມູນໃບບິນ
            
            $bill_id = 1;
            $bid = Bill::all()->sortByDesc('id')->take(1)->toArray();
            foreach($bid as $new){
                $bill_id = $new["bill_id"];
            }

            $new_bid = (int)$bill_id+1; // 1+1 = 2
            $length = 5;
            $new_bill_id = substr(str_repeat(0,$length).$new_bid, - $length);

            $bill = new Bill();
            $bill->bill_id = $new_bill_id;
            $bill->customer_name = $request->customer_name;
            $bill->customer_tel = $request->customer_tel;
            $bill->save();


            
            foreach($request->listorder as $item){

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
                $tran->product_id = $item['id'];
                $tran->tran_type = $request->acc_type;
                $tran->amount = $item['order_amount'];
                $tran->tran_detail = $item['name'];
                $tran->price = $item['order_amount']*$item['price_sell'];
                $tran->save();


                /// ອັບເດດ ຕັດສະຕ໋ອກ
                $store = Store::find($item['id']);

                $store_update = Store::find($item['id']);
                $store_update->update([
                    'amount' => $store->amount - $item['order_amount']
                ]);

                // ບັນທຶກລາຍການ ໃບບິນ

                $bill_list = new Bill_list();
                $bill_list->bill_id = $new_bill_id;
                $bill_list->name = $item["name"];
                $bill_list->amount = $item["order_amount"];
                $bill_list->price = $item["price_sell"];
                $bill_list->save();

            }


            $success = true;
            $message = "ສຳເລັດ!";
        
       } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
       }

       $response = [
            "success"=> $success,
            "message"=>$message,
            "bill_id"=>$new_bill_id
       ];

       return response()->json($response);

    }
}
