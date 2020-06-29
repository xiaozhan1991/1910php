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
}
