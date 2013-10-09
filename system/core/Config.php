<?php

/**
 * DEX_Config  配置类，加载APP目录config文件夹中的配置文件
 * 
 * @author Lancer He <lancer.he@gmail.com> 
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Config {
    
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
        //if config file has environment.

        if ( isset( $CFG[DEX_ENV]) )
            $CFG = $CFG[DEX_ENV];

        $this->data = array_merge($this->data, $CFG);
        return $CFG;
    }
}
