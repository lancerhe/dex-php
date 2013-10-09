<?php

/**
 * DEX_Registry 全局注册
 * 
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Final Class DEX_Registry {

	static $data = array();

	public static function get($key) {
		return (self::has($key) ? self::$data[$key] : NULL);
	}

	public static function set($key, $value) {
		self::$data[$key] = $value;
	}

	public static function has($key) {
		return isset(self::$data[$key]);
	}
}
?>