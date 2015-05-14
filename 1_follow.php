<?php
require './redis.php';
$userid = intval($_GET['userid']);
$page = (!empty($_GET['page'])) ? intval($_GET['page']) : 1;
if ( $userid > 0 && check_login() ) {
    $current_userid = CURRENT_USER_ID;
    if ( $userid != $current_userid ) {
        //用集合来存储用户的关注关系，这样很方便的求交集，差集
        //更方便的给出用户之间共同关注，还有就是推荐等信息
        $redis->sadd(get_follow_key($current_userid), $userid);
        $redis->sadd(get_follower_key($userid), $current_userid);
    }
}
header("Location:./userlist.php?page=" . $page);
