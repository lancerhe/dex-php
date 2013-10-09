<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

define('DEX', TRUE);
define('DEX_VERSION', 3.0);
define('DEX_ENV', 'loc');

define('SYS_FOLDER',    'system');
define('APP_FOLDER',    'app');
define('UPFILE_FOLDER', 'upload');
define('EXT',           '.php');

define('BASE_PATH',   str_replace("\\", DIRECTORY_SEPARATOR, dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('SYS_PATH',    BASE_PATH . SYS_FOLDER . DIRECTORY_SEPARATOR);
define('APP_PATH',    BASE_PATH . APP_FOLDER . DIRECTORY_SEPARATOR);
define('UPFILE_PATH', BASE_PATH . UPFILE_FOLDER . DIRECTORY_SEPARATOR);

define('BASE_URL', 'http://www.example.com');
header ("Content-type:text/html;charset=utf-8");

require_once SYS_PATH . 'Init.php';