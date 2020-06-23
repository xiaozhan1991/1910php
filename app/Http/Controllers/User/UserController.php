<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class UserController extends Controller
{
    //注册
    public function reg()
    {
        return view("user.reg");
    }
    //执行注册
    public function regDo(Request $request)
    {
//        dd(encrypt('123'));
        $user_name = $request->input('user_name');
        $password = $request->input('password');
        $passwords = $request->input('passwords');
        $email = $request->input('email');
//        dd($user_name);

        //验证
        $str=strlen($password);
        if($str<6){
            die("密码长度必须大于六位");
        }

        if($password != $passwords){
            die("密码和确认密码不一致");
        }

       $name = UserModel::where(['user_name'=>$user_name])->first();
        if($name){
            die("此用户名已存在,请从新添加");
        }

       $em = UserModel::where(['email'=>$email])->first();
        if($em){
            die("此邮箱已存在,请从新添加");
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
                echo "注册成功";
            }else{
                echo "注册失败";
            }
    }
    //登录
    public function log()
    {
        return view("user.log");
    }
    //执行登录
    public function logDo(Request $request)
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
            setcookie('uid',$name->user_id,time()+3600,'/');
            setcookie('user_name',$name->user_name,time()+3600,'/');
            header('Refresh:2;url=/user/center');
            echo "登录成功";
        }else{
            header('Refresh:2;url=/user/log');
            echo "用户名和密码不一致";
        }


    }
    //个人中心
    public function center()
    {
        //判断用户是否已登录
        if(isset($_COOKIE['uid']) && isset($_COOKIE['user_name'])){
            return view("user.center");
        }else{
            return redirect("/user/log");
        }
    }
}
