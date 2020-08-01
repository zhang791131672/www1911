<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\APi;
class UserController extends CommonController
{
    //
    public function login(Request $request){
        if($request->isMethod('post')&&$request->ajax()){
            $user_name=$this->checkParamEmpty($request,'user_name');
            $user_pass=$this->checkParamEmpty($request,'user_pass');
            $data=[
                'user_name'=>$user_name,
                'user_pass'=>$user_pass,
            ];
            $response=$this->postRequest(APi::LOGIN,$this->buildParam($data));
            echo $response;die;
        }else{
            return view('login');
        }
    }
    public function register(Request $request){
        if($request->isMethod('post')&&$request->ajax()){
            $user_name=$this->checkParamEmpty($request,'user_name');
            $user_pass=$this->checkParamEmpty($request,'user_pass');
            $user_email=$this->checkParamEmpty($request,'user_email');
            $data=[
                'user_name'=>$user_name,
                'user_pass'=>$user_pass,
                'user_email'=>$user_email
            ];
            $this->postRequest(Api::REGISTER,$this->buildParam($data));
        }else{
            return view('register');
        }
    }
    public function center(){
        return view('center');
    }
}
