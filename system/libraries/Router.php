<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Router {

    private $router_var    = 'C';
    private $controller    = 'Welcome';     //Defalut Controller
    private $action        = 'index';       //Defalut Action
    private $url_mode      = 1;             //Defalut URL Model, 1: Normal, 2: UrlInfo mode
    private $path_info;
    private $file;
    private $class;
    private $method;
    private $args;


    public function __construct() {
        //return instance.
        $Dex =& getInstance();
    	$Dex->request =& loadClass('Request');
        $Dex->config = & loadClass('Config');
        $Dex->config->load('Router');

        if ( ! is_null($Dex->config->get('ROUTER_CONTROLLER') ) )
            $this->controller = ucwords($Dex->config->get('ROUTER_CONTROLLER'));

        if ( ! is_null($Dex->config->get('ROUTER_ACTION') ) )
            $this->action = $Dex->config->get('ROUTER_ACTION');

        if ( ! is_null($Dex->config->get('ROUTER_VAR') ) )
            $this->router_var = $Dex->config->get('ROUTER_VAR');

        if ( ! is_null($Dex->config->get('ROUTER_URL_MODE') ) )
            $this->url_mode = $Dex->config->get('ROUTER_URL_MODE');

        $this->path_info = '';
        if ( isset($Dex->request->server['PATH_INFO']) )
            $this->path_info = $Dex->request->server['PATH_INFO'];
        elseif( isset($Dex->request->server['ORIG_PATH_INFO']) )
            $this->path_info = $Dex->request->server['ORIG_PATH_INFO'];

        $this->args      = $Dex->request->get;
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
            } else {
                $paths  = explode('-', $this->args[$C]);
                if ( count($paths) > 1 )
                    $action = end($paths);
                else
                    $action = $this->action;

                $temp   = explode('/', $paths[0]);
                $control= ucwords(end($temp));
				array_pop($temp);
				array_push($temp, $control);
                $paths  = implode('/', $temp);
                $file   = trim($paths, '/');
            }
			
            $this->file = APP_PATH . 'controllers/' . $file . EXT;

            unset($this->args[$C]);

        } else if ($this->url_mode == 2){

            $path   = trim($this->path_info, '/');
            $paths  = explode('/', $path);
            $path1  = array_shift($paths);
            $folder = '';

            if ( $path1 ) {
                // controller file in sub folder...
                if ( is_dir( APP_PATH . 'controllers/' . $path1) ) {
                    $folder  = $path1;
                    $control = array_shift($paths);
                } else {
                    $control = $path1;
                }
            }

            $action  = array_shift($paths);
            if (empty($action))
                $action = $this->action;

            $this->args = empty($paths) ? array() : $paths;
        }

        $this->setClass($control);
        $this->setMethod($action);
        $this->setFile($folder);
        //print_r($this);
        $request =& loadClass('Request');
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

    public function setFile($folder='') {
        if ($folder)
            $folder = $folder . '/';
        if (file_exists(APP_PATH . 'controllers/' . $folder . $this->controller . EXT)) {
            $this->file = APP_PATH . 'controllers/' . $folder . $this->controller . EXT;
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

        $this->method = $this->action;
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
