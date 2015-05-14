<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require './redis.php';
$userid = intval($_GET['userid']);
if ( $userid > 0 ) {
    $userkey = 'user:' . $userid;
    $userinfo = $redis->hgetall($userkey);
}
if ( intval($_POST['userid']) > 0 ) {
    $userkey = 'user:' . $userid;
    $redis->hset($userkey, 'username', strval($_POST['username'])); 
    $redis->hset($userkey, 'age', intval($_POST['age'])); 
    header("Location:./userlist.php");
}
?>
<form action="" method="post">
用户名：<input type="text" name="username" value="<?php echo $userinfo['username']?>" /><br />
年龄：<input type="text" name="age" value="<?php echo $userinfo['age']?>" /><br />
<input type="hidden" name="userid" value="<?php echo $userid?>" />
<input type="submit" name="submit" value="提交" /><br />
</form>
