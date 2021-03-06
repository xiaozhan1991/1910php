<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    phpinfo();
});

//上课测试
Route::prefix('/test')->group(function(){
    Route::get('/index','IndexController@index');
    Route::get('/sign1','IndexController@sign1');
    Route::get('/shop','IndexController@shop');
    Route::get('/send_data','IndexController@send_data');
    Route::get('/post_data','IndexController@post_data');
    Route::get('/encrypt1','IndexController@encrypt1');//对称加密
});


Route::get('/user/reg','User\UserController@reg');//注册页面
Route::post('/user/regDo','User\UserController@regDo');//执行注册页面
Route::get('/user/log','User\UserController@log');//登录页面
Route::post('/user/logDo','User\UserController@logDo');//执行登录页面

Route::get('/user/center','User\UserController@center');//个人中心页面

//API
Route::post('/api/user/reg','Api\IndexController@reg');//注册页面
Route::post('/api/user/log','Api\IndexController@log');//登录页面
Route::get('/api/user/center','Api\IndexController@center')->middleware('check.pri');//个人中心页面
Route::get('/api/my/orders','Api\IndexController@orders')->middleware('check.pri');//订单页面
Route::get('/api/my/cart','Api\IndexController@cart')->middleware('check.pri');//购物车页面

Route::get('/api/w','Api\TestController@w');
Route::get('/api/t','Api\TestController@t');
Route::get('/api/c','Api\TestController@c');
