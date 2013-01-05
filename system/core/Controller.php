<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Controller {

    function __construct() {
        new DEX_Base($this);

        $this->load     =& loadClass('Loader', 'core');
        $this->config   =& loadClass('Config');
        $this->router   =& loadClass('Router');
        $this->request  =& loadClass('Request');
        $this->response =& loadClass('Response');
        $this->cache    =& loadClass('Cache');

        $this->config->load('Base');
        $autoload = $this->config->get('LOAD_lib');
        if ( ! empty($autoload) ) {
            foreach ($autoload AS $lib) {
                if ($lib == 'Database')
                    $this->db =& loadClass('Database');
                else {
                    $method = strtolower($lib);
                    $this->$method = $this->load->library($lib);
                }
            }
        }
        
        loadHelper('base');
    }


    function __destruct() {
        if ( $this->cache->isOpen() === TRUE AND $this->cache->isLoad() === FALSE ) {
            $this->cache->write(ob_get_contents());
            ob_clean();
            $output = $this->cache->read();
            echo $output;
        }
    }
}