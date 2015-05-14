<?php
require "./redis.php";
$userid = intval($_GET['userid']);
$page = (!empty($_GET['page'])) ? intval($_GET['page']) : 1;
if ( $userid > 0 && check_login() ) {
    $current_userid = CURRENT_USER_ID;
    if ( $userid != $current_userid ) {
        //取消关注
        $redis->srem(get_follow_key($current_userid), $userid);
        $redis->srem(get_follower_key($userid), $current_userid);
    }
}
header("Location:./userlist.php?page=" . $page);
