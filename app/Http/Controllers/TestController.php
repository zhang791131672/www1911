<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class TestController extends Controller
{
     public function index(){
         $url='http://api.1911.com/user/info';
         $response=file_get_contents($url);
         var_dump($response);
     }
    public function userInfo(){
        echo 111;die;
        echo Str::random(32);
    }

    public function aesEncrypt(){
        $data='hello world';
        $key='1911';
        $iv='1234567891234567';
        $encrypt_data=openssl_encrypt($data,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);
        $url='http://api.1911.com/encrypt';
        $client=new Client();
        $encrypt_data=base64_encode($encrypt_data);
//        $response=$client->request('POST',$url,
//            ['form_params'=>[         //form表单参数
//                'data'=>base64_encode($encrypt_data)]
//        ]);
        $response=$client->request('POST',$url,
            ['body'=>$encrypt_data]); //http主体
        echo $response->getBody();
    }
    public function rsaEncrypt(Request $request){
        $encrypt=file_get_contents('php://input');
        $encrypt=base64_decode($encrypt);
        $key=openssl_get_privatekey(file_get_contents(storage_path().'/key/priv.key'));
        openssl_private_decrypt($encrypt,$decrypt,$key);
        //var_dump($decrypt);die;
        $data='项目开发';
        $key=openssl_get_publickey(file_get_contents(storage_path().'/key/apiPub.key'));
        openssl_public_encrypt($data,$encrypt_data,$key);
        return $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>base64_encode($encrypt_data)
        ];
    }

    public function sign1(Request $request){
        $sign=$request->get('sign');
        $data=$request->get('data');
        $key='1911';
        $data_sign=md5($data.$key);
        if($data_sign==$sign){
            echo "成功";
        }else{
            echo "失败";
        }
    }
    public function rsaSign(){
        $data='测试非对称签名';
        $key=openssl_get_privatekey(file_get_contents(storage_path().'/key/priv.key'));
        openssl_sign($data,$signature,$key);
        $url='http://api.1911.com/test/rsaSign?data='.urlencode(base64_encode($data)).'&sign='.urlencode(base64_encode($signature));
        $response=file_get_contents($url);
        echo $response;
    }




    public function rsaPostSign(){
        $data='测试非对称签名';
        $key=openssl_get_privatekey(file_get_contents(storage_path().'/key/priv.key'));
        openssl_sign($data,$signature,$key);
        $url='http://api.1911.com/test/rsaPostSign';
        $client=new Client();
        $response=$client->request('POST',$url,
            ['form_params'=>['sign'=>$signature,'data'=>$data]]);
        echo $response->getBody();
    }


    public function aesSign(){
        $data='abcd';
        $key='1911';
        $iv='1234567891234567';
        $res=openssl_encrypt($data,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);
        $priv_key=file_get_contents(storage_path().'/key/priv.key');
        $priv_key=openssl_get_privatekey($priv_key);
        openssl_sign($res,$signature,$priv_key);
        $client=new Client();
        $url='http://api.1911.com/test/aesSign';
        $response=$client->request('POST',$url,
            ['form_params'=>[
                'data'=>base64_encode($res),
                 'sign'=>base64_encode($signature)
            ]]
            );
        echo $response->getBody();
    }

    public function header(){
        $url='http://api.1911.com/test/header';
        $uid=123;
        $arr=[
            'uid:'.$uid,
        ];
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$arr);
        curl_exec($ch);
        curl_close($ch);
    }

    public function api(){
        echo 111;
    }

    /**
     * 渲染页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testPay(){
        return view('test.pay');
    }

    /**
     * 拼接参数并跳转支付页面
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function pay(Request $request){
        $order_id=$request->get('order_id');
        $request_params=[
            'out_trade_no'=>time().rand(111111,999999),
            'product_code'=>'FAST_INSTANT_TRADE_PAY',
            'total_amount'=>'0.01',
            'subject'=>'Iphone6',
        ];
        $pub_params=[
            'app_id'=>'2016101800713143',
            'method'=>'alipay.trade.page.pay',
            'return_url'=>'http://1911zbw.comcto.com/alipay/return',
            'charset'=>'utf-8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url'=>'http://1911zbw.comcto.com/alipay/notify',
            'biz_content'=>json_encode($request_params),
        ];
        ksort($pub_params);
        $str='';
        foreach($pub_params as $k=>$v){
            $str.=$k.'='.$v.'&';
        }
        $pub_params=rtrim($str,'&');
        $sign=$this->sign($pub_params);
        $http='https://openapi.alipaydev.com/gateway.do?'.$pub_params.'&sign='.urlencode($sign);
        return redirect($http);
    }

    /**
     * 签名
     * @param $data
     * @return string
     */
    protected function sign($data) {
        $priKey = file_get_contents(storage_path().'/key/alipay_priv.key');
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }
}
