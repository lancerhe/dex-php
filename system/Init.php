<?php

/**
 * Init 初始化文件，加载需要的核心文件，进入Bootstrap过程
 * 
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

// Error Reporting
if ( DEX_ENV != 'com' ) {
	define('DEX_DEBUG', TRUE);
    error_reporting(E_ALL);
    ini_set('display_errors','On');
} else {
	define('DEX_DEBUG', FALSE);
    error_reporting(0);
    ini_set('display_errors','Off');
}

// Check Version
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) {
	exit('PHP5.1+ Required');
}

session_set_cookie_params(0, '/');
session_start();
	
// Unset Register Globals
if (ini_get('register_globals')) {
	$globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);

	foreach ($globals AS $global) {
		foreach(array_keys($global) AS $key) {
			unset($$key);
		}
	}
}

// Magic Quotes Fix
if ( ! get_magic_quotes_gpc() ) {
	function clean($data) {
   		if (empty($data))
            return $data;
        else
            return is_array($data) ? array_map('clean', $data) : addslashes($data);
	}

	if ( ! empty($_GET) ) {
        $_GET  = clean($_GET);
    }
    if ( ! empty($_POST) ) {
        $_POST = clean($_POST);
    }

    $_COOKIE   = clean($_COOKIE);
    $_REQUEST  = clean($_REQUEST);
}

if ( ! ini_get('date.timezone') ) {
	date_default_timezone_set('UTC');
}

// Windows IIS Compatibility
if ( ! isset($_SERVER['DOCUMENT_ROOT']) ) {
	if ( isset($_SERVER['SCRIPT_FILENAME']) ) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if ( ! isset($_SERVER['DOCUMENT_ROOT']) ) {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if ( ! isset($_SERVER['REQUEST_URI']) ) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

	if (isset($_SERVER['QUERY_STRING'])) {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}

require_once(SYS_PATH . 'Common.php');
require_once(SYS_PATH . 'core/Dispatcher.php');
require_once(SYS_PATH . 'core/Registry.php');
require_once(SYS_PATH . 'core/Bootstrap.php');
require_once(SYS_PATH . 'core/Controller.php');
require_once(SYS_PATH . 'core/Model.php');
require_once(APP_PATH . 'core/Bootstrap.php');
require_once(APP_PATH . 'core/Controller.php');
require_once(APP_PATH . 'core/Model.php');

$Bootstrap = new Bootstrap();
$Bootstrap->run();