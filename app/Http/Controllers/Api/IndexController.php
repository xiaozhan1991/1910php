<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\TokenModel;
use TheSeer\Tokenizer\Token;

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

    //登录
    public function log(Request $request)
    {
        $user_name = $request->input("user_name");
        $password = $request->input("password");

        //echo "此用户输入的密码：". $password;echo "</br>";

        //验证登录的数据信息
        $name = UserModel::where(["user_name"=>$user_name])->first();
        //echo "数据库中的密码：".$name->password;echo '</br>';

        //验证密码
        $res = password_verify($password,$name->password);
        if($res){
           //生成token
             $str = $name->user_id . $name->user_name . time();
             $token = substr(md5($str),10,16) . substr(md5($str),0,10);

             $data = [
                 'uid' => $name->user_id,
                 'token' => $token
             ];
             TokenModel::insert($data);

             $response = [
                'errno' => 0,
                'msg' => '恭喜，登录成功',
                 'token' => $token
             ];
        }else{
            $response = [
                'errno' => 50006,
                'msg' => '用户名和密码不一致',
            ];
        }
        return $response;
    }

    //个人中心
    public function center()
    {
        //判断用户是否已登录
        $token = $_GET["token"];
        $res = TokenModel::where(['token'=>$token])->first();
        if($res){
            $uid = $res->uid;
            $user_info = UserModel::find($uid);
            echo "欢迎" . $user_info->user_name . "来到个人中心页面~~";
        }else{
            echo "请先进行登录";
        }
    }
}
