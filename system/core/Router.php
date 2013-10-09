<?php

/**
 * Dex_Router   路由信息
 * 
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Router {

    private $router_var    = 'C';
    private $controller    = 'Welcome';     //Defalut Controller
    private $action        = 'index';       //Defalut Action
    private $url_mode      = 1;             //Defalut URL Model, 1: Normal, 2: UrlInfo mode
    private $file;
    private $class;
    private $method;
    private $args;


    public function __construct() {
        //return instance.
        $Dex = DEX_Dispatcher::getInstance();
    	$Dex->request =& loadCore('Request');
        $Dex->config = & loadCore('Config');
        $Dex->config->load('Router');

        if ( ! is_null($Dex->config->get('ROUTER_CONTROLLER') ) )
            $this->controller = ucwords($Dex->config->get('ROUTER_CONTROLLER'));

        if ( ! is_null($Dex->config->get('ROUTER_ACTION') ) )
            $this->action = $Dex->config->get('ROUTER_ACTION');

        if ( ! is_null($Dex->config->get('ROUTER_VAR') ) )
            $this->router_var = $Dex->config->get('ROUTER_VAR');

        if ( ! is_null($Dex->config->get('ROUTER_URL_MODE') ) )
            $this->url_mode = $Dex->config->get('ROUTER_URL_MODE');

        $this->modules = $Dex->config->get('ROUTER_MODULES');
        $this->modules = explode(',', $this->modules);
        $this->args    = $Dex->request->get();
        $this->_init();
    }

    private function _init() {

        $control = $action = '';

        if ($this->url_mode == 1) {
            //Set URL control, action params;
            //print_r($this->args);exit();
            $C = $this->router_var;

            if ( empty($this->args[$C]) ) {
                $file    = ucwords($this->controller);
                $control = ucwords($this->controller);
                $action  = $this->action;
                $dir     = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR;
            } else {
                $paths  = explode('-', $this->args[$C]);
                if ( count($paths) > 1 )
                    $action = end($paths);
                else
                    $action = $this->action;

                $paths  = explode('/', $paths[0]);
                $path1  = array_shift($paths);
                if ( in_array($path1, $this->modules) ) {
                    $dir     = APP_PATH . 'modules' . DIRECTORY_SEPARATOR . $path1 . DIRECTORY_SEPARATOR .'controllers' . DIRECTORY_SEPARATOR;
                    $control = array_shift($paths);
                } else {
                    $dir     = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR;
                    $control = $path1;
                }
            }
        } else if ($this->url_mode == 2) {

            $dir     = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR;
            $action  = $this->action;
            $control = $this->controller;

            if ( isset( $this->args['r'] ) ) {
                $path   = trim( $this->args['r'], '/' );
                $paths  = explode('/', $path);
                $path1  = array_shift($paths);
        
                if ( in_array($path1, $this->modules) ) {
                    $dir     = APP_PATH . 'modules' . DIRECTORY_SEPARATOR . $path1 . DIRECTORY_SEPARATOR .'controllers' . DIRECTORY_SEPARATOR;
                    $control = array_shift($paths);
                } else {
                    $control = $path1;
                }

                $action  = array_shift($paths);
                if (empty($action))
                    $action = $this->action;

                $this->args = empty($paths) ? array() : $paths;
            }
        }

        $this->setClass($control);
        $this->setMethod($action);
        $this->setFile($dir);
        $request =& loadCore('Request');
        $request->args = $this->args;
    }


    public function setUrlMode($mode) {
        $this->url_mode = $mode;
    }


    public function setControllerVar($var) {
        $this->controllerVar = $var;
    }


    public function setActionVar($var) {
        $this->actionVar = $var;
    }


    public function setFile($dir) {
        if (file_exists($dir . $this->controller . EXT)) {
            $this->file = $dir . $this->controller . EXT;
        }
    }


    public function setClass($controller) {
        if ( ! empty($controller))
            $this->controller = ucwords($controller);

        $this->class = $this->controller . 'Controller';;
    }


    public function setMethod($action) {
        if ( ! empty($action))
            $this->action = $action;

        $this->method = $this->action . 'Action';
    }


    public function getFile() {
        return $this->file;
    }


    public function getClass() {
        return $this->class;
    }


    public function getMethod() {
        return $this->method;
    }


    public function getController() {
        return $this->controller;
    }


    public function getAction() {
        return $this->action;
    }


    public function getArgs() {
        return $this->args;
    }


    public function getUrlMode() {
        return $this->url_mode;
    }


    public function getRouterVar() {
        return $this->router_var;
    }
}
?>
