<!DOCTYPE html>

<html>

<head>

    <meta charset=utf8>

    <title>注册页面</title>

</head>

<body>
 <form method="POST" action="{{url('/user/regDo')}}">

        <table>
      @csrf
            <tr>

                <td>用户名：</td><td><input type="text" name="user_name"></td>

            </tr>
            <tr>

                <td>用户邮箱：</td><td><input type="email" name="email"></td>

            </tr>
            <tr>

                <td>密码：</td><td><input type="password" name="password"></td>

            </tr>

            <tr>

                <td>确认密码：</td><td><input type="password" name="passwords"></td>

            </tr>
            <tr>

                <td><input type="submit" value="提交"></td>

            </tr>

        </table>

    </form>

</body>

</html>

