<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class IndexController extends Controller {

    public function indexAction() {
    	$data = array();
    	$data['title'] = 'Welcome DEXPHP';
    	$data['desc']  = 'This is a PHP Framewrok.';
        $this->load->view('welcome', $data);
    }
}