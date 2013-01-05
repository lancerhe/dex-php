<?php

!defined('DEX') && die('Access denied');

$CFG['DB_host']     = "localhost";
$CFG['DB_user']     = "root";
$CFG['DB_pass']     = "root";
$CFG['DB_name']     = "dbname";

$CFG['DB_type']     = "mysql";
$CFG['TB_prefix']   = "dex_";
$CFG['DB_pconnect'] = FALSE;
$CFG['DB_debug']    = TRUE;
$CFG['DB_cache']    = FALSE;
$CFG['DB_cachedir'] = "";
$CFG['DB_charset']  = "utf8";
$CFG['DB_collat']   = "utf8_general_ci";

?>