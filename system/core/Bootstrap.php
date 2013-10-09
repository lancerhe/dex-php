<?php

/**
 * DEX_Bootstrap 初始化类，可继承，以(_init开头的函数将会按顺序执行)
 * 
 * @author Lancer He <lancer.he@gmail.com> 
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Bootstrap {

    public function __construct() {
        $this->router =& loadCore('Router');
    }

    private function _bootController() {
        $controlFile = $this->router->getFile();
        $control     = $this->router->getClass();

        //Check controller file exists;
        if ( ! file_exists($controlFile) ) {
            if ( DEX_DEBUG )
                error('Controller file is not found: ' . $control);
            else
                show404();
        }
        require($controlFile);

        //Check controller class exists;
        if ( ! class_exists($control) ) {
            if ( DEX_DEBUG )
                error('Controller is not defined: '. $control);
            else
                show404();
        }
        $this->instance = new $control;
    }

    private function _bootAction() {
        $action      = $this->router->getMethod();
        $url_mode    = $this->router->getUrlMode();
        $reflection  = new ReflectionClass($this->instance);

        if ( ! $reflection->hasMethod( $action ) ) {
            if ( DEX_DEBUG )
                error('Method is not found: ' . $action);
            else
                show404();
        }

        $reflectionMethod = new ReflectionMethod($this->instance, $action);
        if ( ! $reflectionMethod->isPublic()) {
            if ( DEX_DEBUG )
                error('Method ' . $action . ' is not private.');
            else
                show404();
        }

        $parametersCounts = $reflectionMethod->getNumberOfParameters();

        if ( $parametersCounts > 0 AND $url_mode == 2) {
            $urlArgs = $this->router->getArgs();

            $paramArr = array();
            foreach ($urlArgs AS $key => $param) {
                if ($key > $parametersCounts)
                    break;
                $paramArr[] = '$urlArgs['.$key.']';
            }
            eval('$this->instance->$action(' . implode(',', $paramArr) . ');');
        } else {
            $this->instance->$action();
        }
    }

    private function _bootBootstrap() {
        $reflection  = new ReflectionClass($this);
        $methods     = $reflection->getMethods();
        foreach ($methods AS $row) {
            if ( $row->class != 'Dex_Bootstrap' AND strpos( $row->name, '_init' ) !== FALSE ) {
                $_initAction = $row->name;
                $this->$_initAction();
            }  
        }
    }

    public function run() {
        $this->_bootBootstrap();
        $this->_bootController();
        $this->_bootAction();
    }
}