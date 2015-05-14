<?php
//redis验证密码
define('REDIS_AUTH_PASSWORD',   'mypassword');

define('USER_KEY_FLAG',         'user:');
define('USERNAME_KEY_FLAG',     'username:');
define('USERID_KEY_FLAG',       'userid');
define('USERIDS_FLAG',          'userids');
define('USER_FOLLOWINGS_FLAG',  'followings:');
define('USER_FOLLOWERS_FLAG',   'followers:');

define('AUTH_KEY',              'this is auth key');


/**
 * 获取用户的userkey
 */
function get_ukey($uid) {
    return USER_KEY_FLAG . $uid;
}
/**
 * 获取用户unamekey
 */
function get_uname_key($uname) {
    return USERNAME_KEY_FLAG . $uname;
}
/**
 * 格式化message
 */
function format_message($msg) {
    if ( $msg )
        return base64_encode(urlencode($msg));
}
/**
 * 解析message
 */
function get_message($msg) {
    if ( $msg)
        return urldecode(base64_decode($msg));
}
/**
 * 通过username获取uid
 */
function get_uid($username) {
    if ( $username ) {
        global $redis;
        return $redis->get(get_uname_key($username));
    }
}
/**
 * 获取用户信息
 */
function get_uinfo($uid) {
    global $redis;
    return $redis->hgetall(get_ukey($uid));
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }   
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0); 
    return $ip[$type];
}
/**
 * 判断用户是否登录
 */
function check_login() {
    if ( $_COOKIE['user_auth'] ) {
        //验证登录信息的正确性
        $authinfo = explode("_", $_COOKIE['user_auth']);
        session_start();
        if ( $authinfo[0] == md5(AUTH_KEY . get_client_ip() . $_SESSION['username']) ) {
            $username = $_SESSION['username'];
            $userid   = $authinfo[1];
            define('CURRENT_USER_NAME', $username);
            define('CURRENT_USER_ID',   $userid);
            return true;
        }
    } else {
        define('CURRENT_USER_NAME', '游客');
        define('CURRENT_USER_ID',   0);
        return false;
    }
}
/**
 * 整理用户的关注信息
 */
function format_user_follow(&$users, $getall = false) {
    if ( is_array($users) && count($users) > 0 ) {
        foreach($users as $key => &$value) {
            $value['followings'] = get_user_followings($value['userid']);
            $value['followers']  = get_user_followers($value['userid']);
        }
    }
    return $users;
}
/**
 * 获取redis中的key
 */
function get_follow_key($uid) {
    return USER_FOLLOWINGS_FLAG . $uid;
}
function get_follower_key($uid) {
    return USER_FOLLOWERS_FLAG . $uid;
}
/**
 * 获取用户的关注列表
 */
function get_user_followings_ids($uid, $getall = false) {
    global $redis;
    $follow_ids = $redis->smembers(get_follow_key($uid));
    return $follow_ids;
}
/**
 * 获取用户的粉丝列表
 */
function get_user_followers_ids($uid, $getall = false) {
    global $redis;
    $follower_ids = $redis->smembers(get_follower_key($uid));
    return $follower_ids;
}
function get_user_infos($uids) {
    $data = array();
    if ( is_array($uids) && !empty($uids) ) {
        foreach ( $uids as $key => $value ) {
            $data[$value] = get_uinfo($value);
        }
    }
    return $data;
}
