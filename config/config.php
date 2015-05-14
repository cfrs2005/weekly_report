<?php
/**
 * config.php
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
date_default_timezone_set ( 'Asia/Shanghai' );
ini_set ( 'display_errrors', 1 );
error_reporting ( E_ALL );
session_start ();
define ( 'SITE_PATH', dirname ( __DIR__ ) );
define ( 'MODEL_PATH', SITE_PATH . '/model' );
define ( 'CONFIG_PATH', SITE_PATH . '/config' );
define ( 'UTIL_PATH', SITE_PATH . '/util' );
require_once UTIL_PATH . '/Contaier.php';
// define ( 'CONFIG_PATH', SITE_PATH . '/config' );
// require_once CONFIG_PATH . 'config.php';
