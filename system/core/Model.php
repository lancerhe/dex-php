<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Model {

    protected $db;

    function __construct() {
        $this->db =& loadClass('Database');
    }

}