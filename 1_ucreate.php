<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<h2>创建一个用户</h2>
<form action="" method="post">
    用户名：<input type="text" name="username" value="" /><br />
    密码：<input type="password" name="password" value="" /><br />
    年龄：<input type="text" name="age" value="" /><br />
    <input type="submit" name="submit" value="提交" /><br />
</form>
<?php
require "./redis.php";
$username = strval($_POST['username']);
$password = md5(strval($_POST['password']));
$age      = intval($_POST['age']);
if ( $username && $password  ) {
    $userid     = $redis->incr(USERID_KEY_FLAG);
    $userkey    = get_ukey($userid);
    $ret = $redis->hmset($userkey, array(
        'userid' => $userid, 
        'username' => $username, 
        "password" => $password, 
        "age" => $age
    ));
    if ( $ret ) {
        //把用户的id写入redis，登录验证
        $redis->set(get_uname_key($username), $userid);
        //记录数据库中用户的总数，用链表实现
        $redis->rpush(USERIDS_FLAG, $userid);
        $message = "恭喜，用户创建成功";
    } else {
        //用户创建失败
        $redis->decr(USERID_KEY_FLAG);
        $message = "sorry，用户创建失败";
    }
    header("Location:./userlist.php?message=".format_message($message));
}
