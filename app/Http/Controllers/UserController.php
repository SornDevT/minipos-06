<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class UserController extends Controller
{
    //
    public function register(Request $request){

        try {

            $CheckEmail = User::where("email",$request->email)->get();

            //return $CheckEmail->count();
            if($CheckEmail->count()){

                $success = false;
                $message = "ອີເມວລ໌: ".$request->email." ໄດ້ເຄີຍລົງທະບຽນແລ້ວ! ບໍ່ອານຸຍາດໃຫ້ລົງທະບຽນຊ້ຳອີກ.";
                
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = hash::make($request->password);
                $user->save();
    
                $success = true;
                $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";
            }
        
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

    public function login(Request $request){

        try {

            $check_user_login = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if(Auth::attempt($check_user_login)){
                $success = true;
                $message = "ສຳເລັດ!";
            } else {
                $success = false;
                $message = "ອີເມວລ໌ ຫລື ລະຫັດຜ່ານຂອງທ່ານ ບໍ່ຖຶກຕ້ອງ!";
            }

           
        
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

    public function logout(){

        Session::flush();

        $response = [
            "success"=> true,
            "message"=>"ສຳເລັດ!"
       ];

       return response()->json($response);

    }
}
