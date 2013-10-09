<?php

/**
 * DEX_Loader 装载类库
 * 
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Loader {

    protected $DEX;
    protected $_models     = array();
    protected $_views_path = '';
    protected $_cache_vars = array();

    public function __construct() {
        $this->_views_path = APP_PATH . 'views' . DIRECTORY_SEPARATOR;
    }

    public function setViewPath($path) {
        $this->_views_path = $path;
    }

    public function config($config) {
        $DEX = DEX_Dispatcher::getInstance();
        $DEX->config =& loadCore('Config');
        return $DEX->config->load($config);
    }

    public function database($database='default') {
        $DEX = DEX_Dispatcher::getInstance();
        $DEX->db  =& loadCore('Database');
    }

    public function view($view, $vars = array()) {
        $viewFile = $this->_views_path . $view . EXT;

        if ( ! file_exists($viewFile))
            error('Error: View file is not exists: '.$viewFile);

        $this->addvar($vars);
        ;
        extract($this->_cache_vars);

        include $viewFile;
    }
    
    public function addvar($vars) {
        if ( is_array($vars) ) {
            $this->_cache_vars = array_merge($this->_cache_vars, $vars);
        }
    }

}