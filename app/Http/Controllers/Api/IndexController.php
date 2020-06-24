<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //注册
    public function reg(Request $request)
    {
        $user_name = $request->input('user_name');
        $password = $request->input('password');
        $passwords = $request->input('passwords');
        $email = $request->input('email');

        //验证
        $str=strlen($password);
        if($str<6){
            $response = [
                'errno' => 50001,
                'msg' => '密码长度不能小于六位'
            ];
            return $response;
        }

        if($password != $passwords){
            $response = [
                'errno' => 50002,
                'msg' => '密码和确认密码不一致'
            ];
            return $response;
        }
        //var_dump($user_name);
        $name = UserModel::where(['user_name'=>$user_name])->first();
        if($name){
            $response = [
                'errno' => 50003,
                'msg' => '此用户名已存在,请从新添加'
            ];
            return $response;
        }

        $em = UserModel::where(['email'=>$email])->first();
        if($em){
            $response = [
                'errno' => 50004,
                'msg' => '此邮箱已存在,请从新添加'
            ];
            return $response;
        }
        $pass = password_hash($password, PASSWORD_DEFAULT);
//            $password = password_hash($passwords,PASSWORD_BCRYPT);

        $data = [
            'user_name' => $user_name,
            'email' => $email,
            'password' => $pass,     //添加加密后的
            'reg_time' => time()     //添加的时间
        ];
        $res = UserModel::insert($data);
        if($res){
            $response = [
                'errno' => 0,
                'msg' => '注册成功'
            ];
        }else{
            $response = [
                'errno' => 50005,
                'msg' => '注册失败'
            ];
        }
        return $response;
    }
}
