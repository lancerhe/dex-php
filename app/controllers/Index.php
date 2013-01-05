<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2012
 */

!defined('DEX') && die('Access denied');

class IndexController extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('welcome');
    }
}