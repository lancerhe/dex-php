<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');


function &getInstance() {
	return DEX_Base::getInstance();
}

function loadHelper($helper) {

    // Does the function file has require.
    if ( Registry::has('helper_' . $helper) ) {
        return TRUE;
    }

    $require = FALSE;
    if ( file_exists( APP_PATH . 'helpers/helper_' . $helper . EXT) ) {
        require APP_PATH . 'helpers/helper_' . $helper . EXT;
        $require = TRUE;
    }

    if ( file_exists( SYS_PATH . 'helpers/helper_' . $helper . EXT) ) {
        require SYS_PATH . 'helpers/helper_' . $helper . EXT;
        $require = TRUE;
    }

    if ($require === TRUE) {
        Registry::set('helper_'.$helper, $require);
    } else {
        error('Error: Helper ' . $helper . ' is not found.');
    }
}

function &loadClass($class, $type='libraries') {

    $class = ucwords($class);

    // Does the class exist?  If so, we're done...
    if ( Registry::has($class) ) {
        $instance = Registry::get($class);
        return $instance;
    }

    $folder = $type . '/';
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

    Registry::set($class, $instance);

    $instance = Registry::get($class);

    return $instance;
}

function error($message) {
    echo '<div style="width:98%; white-space:normal; table-layout:fixed; word-break: break-all; overflow:auto; padding:10px; background-color:#EEE; border:1px solid #999; font-size:14px; font-family:Verdana">'.$message.'</div>';
    exit();
}

function show404() {
    Header("HTTP/1.1 404 Not Found");
    ob_clean();
	loadHelper('base');
    include APP_PATH . 'views/404.php';
    exit();
}

