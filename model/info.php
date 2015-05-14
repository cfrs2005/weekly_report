<?php
/**
 * info.php
 * ==============================================
 * Copy right 2013-2014 http://www.80aj.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @param unknowtype
 * @return return_type
 * @author: aj
 * @date: 2015-5-13
 * @version: v1.0.0
 */
class info_model {
	protected static $_instance = null;
	public $_redis_client = null;
	const USER_MEMBER_KEY = 'members:';
	const USER_ID_FLAG = 'userid';
	const USER_ID_LIST = 'userid_list';
	const USER_NAME = 'username';
	const WEEKLY_ID_LIST = 'weeklyid_list';
	const USER_WEEKLY_LIST = 'user_weekly_list';
	const USER_WEEKLY_KEY = 'user_weekly:';
	protected function __construct() {
		$this->__init_info ();
		$redis_info = Contaier::get_config ( 'redis' );
		$this->_redis_client = new Predis\Client ( $redis_info );
	}
	
	/**
	 * 返回自己本身实列
	 */
	public static function __getinstance() {
		if (self::$_instance == null) {
			self::$_instance = new info_model ();
		}
		return self::$_instance;
	}
	
	/**
	 * 初始化加载部分信息
	 */
	private function __init_info() {
		require_once SITE_PATH . '/predis/autoload.php';
	}
	/**
	 * get all members
	 */
	public function _get_members() {
		$uids = $this->_redis_client->lrange ( self::USER_ID_LIST, 0, - 1 );
		if (is_array ( $uids ) && count ( $uids ) > 0) {
			foreach ( $uids as $key => $value )
				$users [] = array (
						'uid' => $value,
						'userinfo' => $this->_get_member_info ( $value ) 
				);
		}
		return $users;
	}
	/**
	 * 存入用户周报
	 *
	 * @param unknown $uid
	 *        	用户id
	 * @param unknown $weekly
	 *        	周数
	 * @param unknown $content
	 *        	正文内容
	 * @param string $status
	 *        	0 发布 1 草稿
	 */
	public function _add_weekly($uid, $weekly, $content, $status = '0') {
		$content_arr = array (
				'content' => $content,
				'status' => $status 
		);
		$this->_redis_client->hmset ( self::USER_WEEKLY_KEY . $uid . ":" . $weekly, $content_arr );
		$this->_redis_client->rpush ( self::USER_WEEKLY_LIST, $weekly );
		return $this->_redis_client->rpush ( self::USER_WEEKLY_LIST . $uid, $weekly );
	}
	/**
	 * 获取用户所有周报
	 *
	 * @param unknown $uid        	
	 * @return multitype:unknown NULL
	 */
	public function _get_user_weekly($uid) {
		$week_ids = $this->_redis_client->lrange ( self::USER_WEEKLY_LIST . $uid, 0, - 1 );
		if (is_array ( $week_ids ) && count ( $week_ids ) > 0) {
			foreach ( $week_ids as $key => $value )
				$weekly_list [] = array (
						'uid' => $uid,
						'weekly' => $value,
						'content' => $this->_get_weekly_info ( $uid, $value ) 
				);
		}
		return $weekly_list;
	}
	
	/**
	 * 获取周报详情
	 *
	 * @param unknown $uid        	
	 * @param unknown $weekly        	
	 */
	public function _get_weekly_info($uid, $weekly) {
		return $this->_redis_client->hgetall ( self::USER_WEEKLY_KEY . $uid . ":" . $weekly );
	}
	
	/**
	 * 获取用户id
	 *
	 * @param unknown $username        	
	 */
	public function _get_userid_by_name($username) {
		return $this->_redis_client->get ( self::USER_NAME . $username );
	}
	
	/**
	 * get user info
	 *
	 * @param unknown $id        	
	 */
	public function _get_member_info($id) {
		return $this->_redis_client->hgetall ( self::USER_MEMBER_KEY . $id );
	}
	
	/**
	 * add member
	 *
	 * @param unknown $memberinfo        	
	 */
	public function _add_member($memberinfo) {
		$userid = $this->_redis_client->incr ( self::USER_ID_FLAG );
		$this->_redis_client->hmset ( self::USER_MEMBER_KEY . $userid, $memberinfo );
		$this->_redis_client->set ( self::USER_NAME . $memberinfo ['username'], $userid );
		return $this->_redis_client->rpush ( self::USER_ID_LIST, $userid );
	}
}