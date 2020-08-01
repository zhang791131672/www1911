<?php

namespace App\Http\Controllers;

use App\Http\APi;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class IndexController extends CommonController
{
    //
    public function index(Request $request){
        $response=$this->getRequest(Api::Index);
        $goods_info=json_decode($response,true);
        return view('index',['new_product'=>$goods_info['data']['goods_new_info'],'top_product'=>$goods_info['data']['goods_top_info']]);
    }
    public function authorize(Request $request){
        $code=$request->get('code');
        if(empty($code)){
            echo "code参数不能为空";die;
        }
        $access_token=$this->getAccessToken($code);
        $access_token='e36fbe4b11056553ed6a96178a0de3061b8b9b17';
        $this->getUserInfo($access_token);
    }


    protected function getAccessToken($code){
        $client=new Client();
        $response=$client->request('POST','https://github.com/login/oauth/access_token',
            ['form_params'=>[
                'client_id'=>'03ddbac7c9673b220cf8',
                'client_secret'=>'4eea7ca64f5e4fa9268a2276888e9e9651af2d79',
                'code'=>$code
            ]]);
        return $response->getBody();
    }
    protected function getUserInfo($access_token){
        $client=new Client();
        $response=$client->request('GET','https://api.github.com/user'.'?Authorization:token '.urlencode($access_token));
        echo $response->getBody();die;
    }
}
