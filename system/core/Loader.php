<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Loader {

    protected $DEX;
    protected $_models     = array();
    protected $_views_path = '';
    protected $_cache_vars = array();

    function __construct() {
        $this->_views_path = APP_PATH . 'views/';
    }

    function config($config) {
        $DEX =& getInstance();
        $DEX->config =& loadClass('Config');
        return $DEX->config->load($config);
    }

    function helper($helper) {
        return loadHelper($helper);
    }

    function library($library = '', $params = NULL) {

        if ($library == '')
            return FALSE;

        if (is_array($library)) {
            foreach ($library AS $l) {
                $this->library($l, $params);
            }
            return;
        }

        $DEX = & getInstance();

        // Is the object exists in Dex.
        if ( isset($DEX->$library) && is_object($DEX->$library))
            return;

        $libraryFile = APP_PATH . 'libraries/' . $library . '.php';
        if ( ! file_exists($libraryFile))
            error('Error: Library file is not exists: '.$library);

        require $libraryFile;

        if ( is_array($params) ) {
            $paramArr = array();
            foreach ($params AS $key => $param) {
                $paramArr[] = '$params['.$key.']';
            }
            eval('$instance = new $library(' . implode(',', $paramArr) . ');');
        } else {
            $instance = new $library();
        }

        $DEX->$library = $instance;
    }

    function database($database='default') {

        $DEX =& getInstance();
        $DEX->db  =& loadClass('Database');
    }

    function model($model) {

        if ( $model == '')
            return;

        if ( is_array($model) ) {
            foreach ($model AS $m) {
                $this->model($m);
            }
            return;
        }

        // Is the model in a sub-folder? If so, parse out the filename and path.
        if ( strpos($model, '/') === FALSE ) {
            $paths = '';
        } else {
            $paths = explode('/', $model);
            $model = end($paths);
            unset($paths[count($paths) - 1]);
            $paths = implode('/', $paths);
        }

        $DEX = & getInstance();

        // Is the object exists in Dex.
        if ( isset($DEX->$model) && is_object($DEX->$model))
            return;

        $modelClass = ucwords($model);

        $modelFile = APP_PATH . 'models/' . $paths . '/' . $modelClass . EXT;
        if ( ! file_exists($modelFile))
            error('Error: Model file is not exists: '.$modelClass);

        require $modelFile;

        $DEX->$model = new $modelClass;
    }


    function view($view, $vars = array()) {
        $viewFile = $this->_views_path . $view . EXT;

        if ( ! file_exists($viewFile))
            error('Error: View file is not exists: '.$viewFile);

        $this->addvar($vars);
        ;
        extract($this->_cache_vars);

        include $viewFile;
    }
    
    function addvar($vars) {
        if ( is_array($vars) ) {
            $this->_cache_vars = array_merge($this->_cache_vars, $vars);
        }
    }

}