<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class CommonController extends Controller
{
    /**
     * 发送get请求
     */
    protected function getRequest($url){
        $client=new Client();
        $response=$client->request('GET',$url);
        return $response->getBody();
    }
    /**
     * 发送post请求
     * @param $url
     * @param $data
     */
    protected function postRequest($url,$data){
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'all_data'=>$data
            ]
        ]);
        return  $response->getBody();
    }

    /**
     * 进行加密签名拼接最终数据
     * @param array $data
     * @return array
     */
    protected function buildParam(array $data){
        $request_all_data=[];
        $request_all_data['data']=$this->aesEncrypt($data);
        $request_all_data['sign']=$this->clientSign($data);
        return $request_all_data;
    }

    /**
     * 对称加密
     * @param array $data
     * @return string
     */
    protected function aesEncrypt(array &$data){
        $app_id=env('APP_ID');
        $data['rand']=rand(10,99);
        $data['time']=time();
        $data['app_id']=$app_id;
        $key=env('KEY');
        $iv=env('IV');
        $encrypt_data=json_encode($data);
        $encrypt_data=openssl_encrypt($encrypt_data,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);
        return base64_encode($encrypt_data);
    }

    /**
     * 生成签名
     * @param $data
     * @return string
     */
    protected function clientSign(&$data){
        $app_id=env('APP_ID');
        $data['app_id']=$app_id;
        $app_secret=env('APP_SECRET');
        ksort($data);
        $data=http_build_query($data);
        $data=$data.'&app_secret='.$app_secret;
        return md5($data);
    }

    /*
     * 检查参数
     */
    public function checkParamEmpty(Request $request,$key){
        $value=$request->post($key);
        if(empty($value)){
            $this->fail(1,'请检查'.$key.'必填项不能为空');
        }else{
            return $value;
        }
    }

    /**
     * 失败返回的json串
     * @param $errno
     * @param string $msg
     * @param int $status
     */
    protected function fail($errno,$msg='fail',$data=[]){
        echo json_encode($this->response($errno,$msg,$data));die;
    }
    /**
     * 封装响应回去的数组
     * @param $errno
     * @param $msg
     * @param $status
     * @return array
     */
    protected function response($errno,$msg,$data){
        $arr=[
            'errno'=>$errno,
            'msg'=>$msg,
            'data'=>$data,
        ];
        return $arr;
    }
}
