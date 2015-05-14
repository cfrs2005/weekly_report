<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
require "./redis.php";
echo get_message ( strval ( $_GET ['message'] ) ) . "<br />";
if (check_login ()) {
	echo "欢迎回来，" . CURRENT_USER_NAME . " <a href='./logout.php'>【退出】</a>";
} else
	echo "欢迎你，游客 <a href='./login.php'>【登录】</a>";
	// 分页
	// 用户总数
$count = $redis->lsize ( USERIDS_FLAG );
// 页大小
$page_size = 3;
// 当前页
$page = (! empty ( $_GET ['page'] )) ? intval ( $_GET ['page'] ) : 1;
// 页总数
$page_count = ceil ( $count / $page_size );
/**
 * 第一页
 * lrange key 0 2
 * 第二页
 * lrange key 3 5
 * 第三页
 * lrange key 6 8
 * 第n页
 * lrange key ($page-1) * $page_size, ($page_size * $page) - 1
 */
$start = ($page - 1) * $page_size;
$end = ($page_size * $page) - 1;
$users = array ();
$uids = $redis->lrange ( USERIDS_FLAG, $start, $end );
if (is_array ( $uids ) && count ( $uids ) > 0) {
	foreach ( $uids as $key => $value )
		$users [] = get_uinfo ( $value );
}
if (empty ( $users ))
	header ( "Location:./ucreate.php" );
	// 获取用户关注的人列表
$user_followings_ids = get_user_followings_ids ( CURRENT_USER_ID, true );
$user_followers_ids = get_user_followers_ids ( CURRENT_USER_ID, true );
?>
<h3>
	<a href="./ucreate.php" style="font-weight: bold; color: #f00">添加用户</a>
</h3>
<table>
	<tr>
		<th>ID</th>
		<th>用户名</th>
		<th>年龄</th>
		<th>操作</th>
	</tr>
    <?php
				if (is_array ( $users ) && count ( $users ) > 0) {
					foreach ( $users as $key => $val ) {
						?>
    <tr>
		<td><?php echo $val['userid']?></td>
		<td><?php echo $val['username']?></td>
		<td><?php echo $val['age']?></td>
		<td><a href="./edituser.php?userid=<?php echo $val['userid']?>">编辑</a>
			<a href="./deluser.php?userid=<?php echo $val['userid']?>">删除</a>
            <?php if ( CURRENT_USER_ID > 0 ) {?>
            <?php
							
if (CURRENT_USER_ID != $val ['userid']) {
								if (in_array ( $val ['userid'], $user_followings_ids )) {
									echo "<a href='./delfollow.php?userid={$val[userid]}&page={$page}'>取消关注</a>";
								} else {
									?>
                <a
			href="./follow.php?userid=<?php echo $val['userid']?>&page=<?php echo $page?>">关注</a>
            <?php
								}
								if (in_array ( $val ['userid'], $user_followers_ids )) {
									echo '已粉';
								}
							}
							?>
        </td>
	</tr>
    <?php }}?>
    <tr>
		<td colspan=4><a href="?page=1">首页</a> <a
			href="?page=<?php echo ($page - 1) > 0 ? ($page - 1) : 1?>">上一页</a>
			当前页:<span style="color: #f60"><?php echo $page?></span> <a
			href="?page=<?php echo ($page + 1 > $page_count) ? $page_count : $page + 1?>">下一页</a>
        总页数:<?php echo $page_count?>
        总条数:<?php echo $count?>
        <a href="?page=<?php echo $page_count?>">尾页</a></td>
	</tr>
    <?php }?>
</table>
<div>
<?php
if ($user_followings_ids) {
	echo "我的关注<br />";
	$follow_users = get_user_infos ( $user_followings_ids );
	if (is_array ( $follow_users ) && count ( $follow_users ) > 0) {
		foreach ( $follow_users as $k => $v ) {
			$f_u .= $v ['username'] . " ";
		}
	}
	echo $f_u . "<br />";
	?>
<?php }?>
<?php


if ($user_followers_ids) {
	echo "我的粉丝<br />";
	$follower_users = get_user_infos ( $user_followers_ids );
	if (is_array ( $follower_users ) && count ( $follower_users ) > 0) {
		foreach ( $follower_users as $k => $v ) {
			$f_u .= $v ['username'] . " ";
		}
	}
	echo $f_u . "<br />";
	?>
<?php }?>
</div>