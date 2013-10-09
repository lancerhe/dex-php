<?php

/**
 * Common 核心公用函数，用于核心目录下使用的基本函数
 * 
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

function __autoload($class_name){
    //is model class or a library.
    if ( strpos( $class_name, 'Model' ) !== FALSE ) {
        $file = APP_PATH . 'models' . DIRECTORY_SEPARATOR . str_replace('Model', '', $class_name) . EXT;
        if ( ! file_exists( $file ) ) 
            error("Model File: $file not exist.");

        require($file);
    } else {
        //is class in folder.
        $class_name = explode( '_' , $class_name );
        $file       = APP_PATH . 'libraries' . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR , $class_name) . EXT;
        if ( ! file_exists( $file ) ) 
            error("Library File: $file not exist.");

        require($file);
    }
}

function &loadCore($class) {

    $class = ucwords($class);

    // Does the class exist?  If so, we're done...
    if ( DEX_Registry::has($class) ) {
        $instance = DEX_Registry::get($class);
        return $instance;
    }

    $folder = 'core' . DIRECTORY_SEPARATOR;
    // Does the class has been extends.
    if ( file_exists( APP_PATH . $folder . $class . EXT) ) {
        require SYS_PATH . $folder . $class . EXT;
        require APP_PATH . $folder . $class . EXT;
        $subclass = TRUE;
    } else {
        require SYS_PATH . $folder . $class . EXT;
        $subclass = FALSE;
    }

    // Register to global.
    $name = $subclass == TRUE ? $class : 'DEX_' . $class;

    $instance = new $name();

    DEX_Registry::set($class, $instance);

    $instance = DEX_Registry::get($class);

    return $instance;
}

function error($message) {
    if ( DEX_DEBUG ) {
        echo '<div style="width:98%; white-space:normal; table-layout:fixed; word-break: break-all; overflow:auto; padding:10px; background-color:#EEE; border:1px solid #999; font-size:14px; font-family:Verdana">'.$message.'</div>';  
    } else {
        show404();
    }
    exit();
}

function show404() {
    Header("HTTP/1.1 404 Not Found");
    ob_clean();
    if ( file_exists(APP_PATH . 'views' . DIRECTORY_SEPARATOR . '404.php') )
        include APP_PATH . 'views' . DIRECTORY_SEPARATOR . '404.php';
    else
        error('404 Not Found');
    exit();
}

function site_url($url = '') {
    if ( $url ) {
        $url        = ltrim($url, '/');
        $url_mode   = DEX_Dispatcher::getInstance()->config->get('ROUTER_URL_MODE');
        $router_var = DEX_Dispatcher::getInstance()->config->get('ROUTER_VAR');
        if ($url_mode == 1)
            return rtrim(BASE_URL, '/') . "/index.php?{$router_var}=" . $url;
        else
            return rtrim(BASE_URL, '/') . '/' . $url;
    }
    return rtrim(BASE_URL, '/');
}