<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php 
require './redis.php';
echo get_message($_GET['message']);
?>
<form action="" method="post">
    用户名：<input type="text" name="username" value="" /><br />
    密码：<input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="登录" /><br />
</form>
<?php
$username = strval($_POST['username']);
$password = md5(strval($_POST['password']));
//通过$username获取用户id
$userid = get_uid($username);
//获取用户信息
if ( $userid > 0 ) {
    $userinfo = $redis->hgetall(get_ukey($userid));
    if ( is_array($userinfo) && count($userinfo) > 0 ) {
        if ( $userinfo['password'] == $password ) {
            //种cookie
            $user_auth = md5(AUTH_KEY . get_client_ip() . $username) . '_' . $userid;
            setcookie('user_auth', $user_auth, time() + 86400);
            session_start();
            $_SESSION['username'] = $username;
            header("Location:./userlist.php");
        } else {
            $message = '用户名或者密码错误';
            header("Location:./login.php?message=" . format_message($message));
        }
    }
}
