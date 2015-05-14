<?php
/**
 * functions.php
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
class Contaier {
	public static function get_config($key) {
		$file = CONFIG_PATH . "/" . $key . '.php';
		if (file_exists ( $file )) {
			$arr = include $file;
			if (! empty ( $arr )) {
				return $arr;
			}
		}
		return array ();
	}
	
	/**
	 * 获取最近的五周
	 *
	 * @return Ambigous <multitype:string, multitype:string >
	 */
	public static function last_five_week_time() {
		$week_array [] = self::_get_week_info ( 2, false );
		$week_array [] = self::_get_week_info ( 1, false );
		$week_array [] = self::_get_week_info ( 0, true );
		$week_array [] = self::_get_week_info ( 1, true );
		$week_array [] = self::_get_week_info ( 2, true );
		return $week_array;
	}
	
	/**
	 * 通过周数反溯星期一和星期天
	 *
	 * @param unknown $week_num
	 *        	周数
	 * @param string $year
	 *        	年份
	 * @return multitype:string
	 */
	public static function week_num_to_days($week_num, $year = '') {
		if (! empty ( $year )) {
			$year = date ( "Y" );
		}
		$week_str = $year . "-W" . $week_num;
		$monday = date ( "Y-m-d", strtotim ( $week_str ) );
		$sunday = date ( "Y-m-d", strtotim ( $week_str ) + 604800 - 1 );
		return array (
				'monday' => $monday,
				'sunday' => $sunday 
		);
	}
	
	/**
	 * 返回当前日期的周数以及星期一和星期天
	 *
	 * @param unknown $num
	 *        	需要距离当前时间的周数
	 * @param string $flag
	 *        	true为往后叠加 false 为往前推算
	 * @return multitype:string
	 */
	public static function _get_week_info($week_num, $flag = true) {
		$time_arr = array ();
		
		if (! $flag) {
			$week_num = (- 1) * $week_num;
		}
		$monday_time = strtotime ( "last Monday" ) + 604800 * $week_num;
		$sunday_time = strtotime ( "this Sunday" ) + 604800 * $week_num;
		
		$time_arr ['monday'] = date ( 'Y-m-d', $monday_time );
		$time_arr ['sunday'] = date ( 'Y-m-d', $sunday_time );
		$time_arr ['weeklynum'] = date ( 'W', $monday_time );
		return $time_arr;
	}
}
