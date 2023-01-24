<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Bill_list;

class BillController extends Controller
{
    //

    public function print_bill($id){


        $bill = Bill::where('bill_id',$id)->get();
        $bill_list = Bill_list::where('bill_id',$id)->get();
        // return $bill;
       return view('bill')->with('bill',$bill)->with('bill_list',$bill_list)->with('bill_id',$id);
    }
}
