<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Final Class Dex_Front {

    function __construct() {
        $this->router = &loadClass('Router');
        $this->init();
    }

    private function init() {
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

    function run() {

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
        //$this->instance->$action();
    }

}