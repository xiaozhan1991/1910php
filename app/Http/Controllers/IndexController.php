<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    public function index()
    {
        echo 'hhh';
    }

    //测试redis
    public function redis1()
    {
        $key = 'name2';
        $val1 = Redis::get($key);
        var_dump($val1);echo '<br>';
        echo '$val1: '. $val1;
    }
    //签名测试
    public function sign1()
    {
        $key = 'd6sel9t84jkldes';
        $data = '未来可期~~';
        $sign = sha1($data.$key);
        echo "将要发送的数据：".$data;echo "</br>";
        echo "要发送前生成的签名：".$sign;echo "</br>";

        $g_url = "http://www.1910.com/secret?data=".$data."&sign=".$sign;
        echo $g_url;
    }
    public function secret()
    {
        $key = 'd6sel9t84jkldes';
        //验证签名
        //接收的数据
        $data = $_GET['data'];
        //接收的签名
        $sign = $_GET['sign'];

        $local_sign = sha1($data.$key);
        echo "本地的签名是：".$local_sign;echo "</br>";
        if($sign == $local_sign){
            echo "验证签名通过";
        }else{
            echo "验证签名未通过";
        }
    }
    public function shop()
    {
        $url = "http://api.1910.com/api/info";
        $key = 'wtc';
        //给接口发送数据(get方式)
        $data = 'gcy';
        $sign = sha1($data.$key);

        $url = $url.'?data='.$data.'&sign='.$sign;

        //php发起网络请求s
        $response = file_get_contents($url);
        echo $response;
    }

    public function send_data()
    {
        $url = "http://api.1910.com/test/receive?name=gcy&age=17";
        $response = file_get_contents($url);
        echo $response;
    }

    public function post_data()
    {
        $key = 'secret';
        $data = [
            'name' => 'girl',
            'age' => 17
        ];
        $str = json_encode($data).$key;
        $sign = sha1($str);

        $send_data = [
            'data' => json_encode($data),
            'sign' => $sign
        ];

        $url = "http://api.1910.com/test/receivePost";
        //给接口发数据(post方式)
        $chen = curl_init();
        //配置参数
        curl_setopt($chen,CURLOPT_URL,$url);
        curl_setopt($chen,CURLOPT_POST,1);
        curl_setopt($chen,CURLOPT_POSTFIELDS,$send_data);
        curl_setopt($chen,CURLOPT_RETURNTRANSFER,1);

        //开启会话
        $response = curl_exec($chen);

        //检测错误
        $errno = curl_errno($chen);
        $errmsg = curl_error($chen);
        if($errno){
            var_dump($errmsg);die;
        }
        curl_close($chen);
        echo $response;
    }

    //对称加密
    public function encrypt1()
    {
        $data = "万里星河不及你";
        $method = "AES-256-CBC";
        $key = "1910api";
        $iv = "xiaochentongxue~";

        //加密
        $encr_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);

        //签名
        $sign = sha1($encr_data.$key);
        //var_dump($encr_data);echo '</br>';
        $post_data = [
            'data' => $encr_data,
            'sign' => $sign
        ];

        //发送密文到对端(post方式)
        $url = "http://api.1910.com/test/decrypt1";
        $chen = curl_init();

        curl_setopt($chen,CURLOPT_URL,$url);
        curl_setopt($chen,CURLOPT_POST,1);
        curl_setopt($chen,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($chen,CURLOPT_RETURNTRANSFER,1);

        //开启会话
       $response =  curl_exec($chen);
       echo $response;

        //捕捉错误
        $errno = curl_errno($chen);
        if($errno){
            $errmsg = curl_error($chen);
            var_dump($errmsg);die;
        }

        //关闭连接
        curl_close($chen);
    }
}
