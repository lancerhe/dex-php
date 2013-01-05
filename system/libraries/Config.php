<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Config {
    
    private $data = array();
    
    public function get($key) {
        return ($this->has($key) ? $this->data[$key] : NULL);
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function has($key) {
        return isset($this->data[$key]);
    }

    public function load($name) {
        $file = APP_PATH . 'config/'. $name . EXT;

        if ( ! file_exists($file) ) 
            return FALSE;

        $CFG = array();

        require($file);
        $this->data = array_merge($this->data, $CFG);
        return $CFG;
    }
}
