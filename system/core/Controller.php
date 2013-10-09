<?php

/**
 * DEX_Controller  控制器
 * 
 * @author Lancer He <lancer.he@gmail.com> 
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Controller {

    public function __construct() {
        new DEX_Dispatcher($this);

        $this->load     =& loadCore('Loader', 'core');
        $this->config   =& loadCore('Config');
        $this->router   =& loadCore('Router');
        $this->request  =& loadCore('Request');
        $this->response =& loadCore('Response');
        $this->cache    =& loadCore('Cache');
    }


    public function __destruct() {
        if ( $this->cache->isOpen() === TRUE AND $this->cache->isLoad() === FALSE ) {
            $this->cache->write(ob_get_contents());
            ob_clean();
            $output = $this->cache->read();
            echo $output;
        }
    }
}