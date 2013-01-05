<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class DEX_Base {

    private static $_instance;

	public function __construct($dex) {
		self::$_instance =& $dex;
	}

	public static function &getInstance() {
        return self::$_instance;
	}
}