<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

define('DEX', TRUE);
define('DEX_VERSION', 1.0);
define('DEX_DEBUG', FALSE);

define('SYS_FOLDER',    'system');
define('APP_FOLDER',    'app');
define('UPFILE_FOLDER', 'upload');

define('BASE_PATH', str_replace("\\", "/", dirname(__FILE__)) . '/');

define('SYS_PATH',    BASE_PATH . SYS_FOLDER . '/');
define('APP_PATH',    BASE_PATH . APP_FOLDER . '/');
define('UPFILE_PATH', BASE_PATH . UPFILE_FOLDER . '/');
define('EXT', '.php');

define('BASE_URL', 'http://local.mvc.com/');
header ("Content-type:text/html;charset=utf-8");

require_once SYS_PATH . 'Init.php';

