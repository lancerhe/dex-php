<?php

/**
 * DEX_Dispatcher 调度基类，返回DEX框架中调度模式
 * 
 * @author Lancer He <lancer.he@gmail.com> 
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Final Class DEX_Dispatcher {

    static private $_instance;

	public function __construct($dex) {
		self::$_instance =& $dex;
	}

	static public function &getInstance() {
        return self::$_instance;
	}
}