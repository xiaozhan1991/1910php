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
}
