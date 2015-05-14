<?php
/**
 * curd.php
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
require_once __DIR__ . '/config/config.php';
require_once MODEL_PATH . '/info.php';
class info_curd {
	// 初始化model类 info_model
	public $_info_model = null;
	const CODE_SUCCEED = 0;
	const CODE_UNKNOW = 1;
	const CODE_NOT_FOUND = 2;
	const CODE_QUERY_FAIL = 3;
	const CODE_PARAMETER_ERROR = 4;
	const CODE_TIMEOUT = 5;
	protected static $_messag_text = array (
			self::CODE_SUCCEED => 'OK',
			self::CODE_UNKNOW => 'Unknow',
			self::CODE_NOT_FOUND => 'Not found',
			self::CODE_QUERY_FAIL => 'Database query failed',
			self::CODE_PARAMETER_ERROR => 'Parameter error',
			self::CODE_TIMEOUT => 'Execution timeout' 
	);
	// 初始化 返回js数据格式
	protected $_callback_data = array ();
	
	// 构造, 初始化实例话对象
	function __construct() {
		$this->_info_model = info_model::__getinstance ();
		$this->_callback_data = array (
				'code' => self::CODE_SUCCEED,
				'msg' => self::$_messag_text [self::CODE_SUCCEED],
				'data' => '' 
		);
	}
	/**
	 * user login
	 */
	public function login() {
		// $postdata=file_get_contents ( "php://input" );
		// $request = json_decode($postdata);
		$username = ! empty ( $_POST ['username'] ) ? $_POST ['username'] : "";
		$userpassword = ! empty ( $_POST ['password'] ) ? $_POST ['password'] : "";
		if (! empty ( $username ) && ! empty ( $userpassword )) {
			$userid = $this->_info_model->_get_userid_by_name ( $username );
			if (! empty ( $userid )) {
				$userinfo = $this->_info_model->_get_member_info ( $userid );
				if ($userpassword == $userinfo ['password']) {
					$_SESSION ['username'] = $userinfo ['username'];
					$_SESSION ['uid'] = $userid;
				} else {
					$this->_change_msg ( 2 );
				}
			} else {
				$this->_change_msg ( 2 );
			}
		} else {
			$this->_change_msg ( 4 );
		}
		echo $this->_response_type ();
	}
	// 表单保存添加 用户
	public function addmember() {
		$uid = time ();
		$username = ! empty ( $_REQUEST ['username'] ) ? trim ( $_REQUEST ['username'] ) : '';
		$mid = ! empty ( $_REQUEST ['mid'] ) ? trim ( $_REQUEST ['mid'] ) : '';
		$password = ! empty ( $_REQUEST ['password'] ) ? trim ( $_REQUEST ['password'] ) : '';
		// test
		$username = "安静";
		$mid = 0;
		$password = '123';
		$member_info = array (
				'uid' => $uid,
				'username' => $username,
				'mid' => $mid,
				'password' => $password 
		);
		$this->_info_model->_add_member ( $member_info );
	}
	// 表单保存用户提交的周报数据
	public function addworkly() {
		$weeklynum = ! empty ( $_POST ['weeklynum'] ) ? $_POST ['weeklynum'] : '';
		$content = ! empty ( $_POST ['content'] ) ? $_POST ['content'] : '';
		$status = ! empty ( $_GET ['savestatus'] ) ? intval ( $_GET ['savestatus'] ) : 0;
		$uid = $_SESSION ['uid'];
		if (! empty ( $weeklynum ) && ! empty ( $content ) && ! empty ( $uid )) {
			$result = $this->_info_model->_add_weekly ( $uid, $weeklynum, $content, $status );
			if (! $result) {
				$this->_change_msg ( 3 );
			}
		} else {
			$this->_change_msg ( 4 );
		}
		
		echo $this->_response_type ();
	}
	/**
	 * 获取当前用户所有周报
	 */
	public function getmemberweekly() {
		$uid = $_SESSION ['uid'];
		if (empty ( $uid )) {
			$this->_change_msg ( 4 );
		} else {
			$weekly_list = $this->_info_model->_get_user_weekly ( $uid );
			$this->_callback_data ['data'] = $weekly_list;
		}
		echo $this->_response_type ();
	}
	
	// 表单获取所有用户
	public function getmembers() {
		return $this->_info_model->_get_members ();
	}
	public function showuserwork() {
	}
	public function sendmail() {
	}
	
	/**
	 * 设置返回的内容
	 *
	 * @param unknown $code        	
	 */
	private function _change_msg($code) {
		$this->_callback_data = array (
				'code' => $code,
				'msg' => self::$_messag_text [$code],
				'data' => '' 
		);
	}
	
	/**
	 * response reuslt by type
	 *
	 * @param string $type        	
	 * @return string
	 */
	private function _response_type($type = "json") {
		switch ($type) {
			case 'json' :
				header ( 'Content-Type: application/x-javascript; charset=utf-8' );
				return json_encode ( $this->_callback_data );
				break;
			case 'jsonp' :
				header ( 'Content-Type: application/x-javascript; charset=utf-8' );
				return json_encode ( $this->_callback_data ) . '&callback=' . $_GET ['callback'];
				break;
			default :
				return $this->_callback_data;
				break;
		}
	}
}

$curd = new info_curd ();
$action = $_REQUEST ['action'];
if (! empty ( $action ) && method_exists ( $curd, $action )) {
	$curd->$action ();
}

exit ();
// 删除key
// $curd->_info_model->_redis_client->del ( 'members' );
// exit ();
$curd->addmember ();
$list_members = $curd->getmembers ();

foreach ( $list_members as $member ) {
	$member ['userinfo'] ['password'] = ! empty ( $member ['userinfo'] ['password'] ) ? $member ['userinfo'] ['password'] : '';
	echo "用户UID: " . $member ['uid'] . " 用户名:" . $member ['userinfo'] ['username'] . " 用户邮件抄送人:" . $member ['userinfo'] ['mid'] . "用户密码:" . $member ['userinfo'] ['password'] . "<br>";
}
//var_dump ( $list_members );





// var_dump ( $info_model->_get_members () );
// $info_model->_redis_client->hmset ( 'hash1', array (
// 		'key3' => 'v3',
// 		'key4' => 'v4' 
// ) );
// $info = $info_model->_redis_client->hmget ( 'hash1', array (
// 		'key3',
// 		'key4' 
// ) );
