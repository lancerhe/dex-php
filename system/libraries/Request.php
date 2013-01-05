<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Request {

    public $args   = array();
	public $get    = array();
	public $post   = array();
	public $cookie = array();
	public $files  = array();
	public $server = array();



  	public function __construct() {
		$this->get = $_GET;
		$this->post = $_POST;
		$this->cookie = $_COOKIE;
		$this->files = $_FILES;
		$this->server = $_SERVER;
	}


  	public function escape($data, $quotestyle=ENT_COMPAT) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);

	    		$data[$this->escape($key)] = $this->escape($value);
	  		}
		} else {
	  		$data = htmlspecialchars($data, $quotestyle, 'UTF-8');
		}

		return $data;
	}
}
?>
