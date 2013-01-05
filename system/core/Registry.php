<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

final class Registry {
	static $data = array();

	public function get($key) {
		return (self::has($key) ? self::$data[$key] : NULL);
	}

	public function set($key, $value) {
		self::$data[$key] = $value;
	}

	public function has($key) {
		return isset(self::$data[$key]);
	}
}
?>