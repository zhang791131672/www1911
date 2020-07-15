<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index(){
        echo "hello world";
    }

    public function getAccessToken(){
        $appid='wx5efbe8932db24806';
        $appsecret='fe8604bcaaca5d3c5fdde138be496435';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $res=file_get_contents($url);
        dd($res);
    }
    public function getAccessToken2(){
        $appid='wx5efbe8932db24806';
        $appsecret='fe8604bcaaca5d3c5fdde138be496435';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        //开启curl
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //执行
        $response=curl_exec($ch);
        curl_close($ch);
        var_dump($response);
    }
}
