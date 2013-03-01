<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Request {

	private $get    = array();
	private $post   = array();
	private $cookie = array();
	private $files  = array();
	private $server = array();

  	public function __construct() {
		$this->get    = $_GET;
		$this->post   = $_POST;
		$this->cookie = $_COOKIE;
		$this->files  = $_FILES;
		$this->server = $_SERVER;

		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_FILES);
		unset($_SERVER);
	}
	
	private function filter($data_type, $key=NULL, $escape=FALSE, $xss=FALSE) {
		if ( is_null( $key ) ) {
			$data = $data_type;
		} else {
			$data = isset($data_type[$key]) ? $data_type[$key] : NULL;
		}

		if ( is_null($data) )
			return NULL;

		if ( $escape ) {
			$data = $this->escape($data);
		}

		if ( $xss ) {
			$data = $this->xss($data);
		}

		return $data;
	}

	public function get($key=NULL, $escape=FALSE, $xss=FALSE) {
		return $this->filter($this->get, $key, $escape, $xss);
	}

	public function post($key=NULL, $escape=FALSE, $xss=FALSE) {
		return $this->filter($this->post, $key, $escape, $xss);
	}

	public function cookie($key=NULL, $escape=FALSE, $xss=FALSE) {
		return $this->filter($this->cookie, $key, $escape, $xss);
	}

	public function files($key=NULL, $escape=FALSE, $xss=FALSE) {
		return $this->filter($this->files, $key, $escape, $xss);
	}

	public function server($key=NULL, $escape=FALSE, $xss=FALSE) {
		return $this->filter($this->server, $key, $escape, $xss);
	}

	
	public function xss($data) {
		return $data;
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
