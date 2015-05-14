<?php
require "./redis.php";
if ( ($userid = intval($_GET['userid'])) > 0 ) {
    $userkey = get_ukey($userid);
    $result = $redis->delete($userkey);
    if  ( $result ) {
        //如果删除成功，用户userids也删除对应的值
        $redis->lrem(USERIDS_FLAG, $userid);
        $message = "恭喜，操作成功";
    } else $message = "sorry，操作失败";

    header("Location:./userlist.php?message=" . format_message($message));
}
