<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function w()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri_hash = substr(md5($request_uri),5,10);

        $expire = 10;

        $key = 'access_total_'.$uri_hash;
        $total = Redis::get($key);
        if($total > 10){
            echo "此请求过于频繁，请 {$expire} 后尝试";
            //设置key的过期时间
            Redis::expire($key,$expire);
        }else{
            Redis::incr($key);
            echo '当前访问的次数是'.$total;
        }
    }
    public function t()
    {
        $key = 'access_total_t';
        $total = Redis::incr($key);
        if($total > 10){
            echo "此请求过于频繁，请稍后尝试";
        }else{
            echo '当前访问的次数是'.$total;
        }
    }
    public function c()
    {
        $key = 'access_total_c';
        $total = Redis::incr($key);
        if($total > 10){
            echo "此请求过于频繁，请稍后尝试";
        }else{
            echo '当前访问的次数是'.$total;
        }
    }
}
