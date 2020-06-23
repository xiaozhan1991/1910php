<!DOCTYPE html>

<html>

<head>

    <meta charset=utf8>

    <title>登录页面</title>

</head>
<body>
<form method="post" action="{{url('user/logDo')}}">

    <table>
    @csrf
        <tr>

            <td>用户名：</td><td><INPUT type="text" name="user_name"></td>

        </tr>

        <tr>

            <td>密码：</td><td><input type="password" name="password"></td>

        </tr>

        <tr>

            <td><input type="submit" value="提交"></td>

        </tr>

    </table>

</form>
</body>
</html>
