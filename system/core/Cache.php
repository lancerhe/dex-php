<?php

/**
 * DEX_Cache 缓存类，开启缓存后，缓存会存在APP目录下的cache文件夹
 * 
 * @author Lancer He <lancer.he@gmail.com> 
 * @copyright 2013
 */

!defined('DEX') && die('Access denied');

Class DEX_Cache {

    protected $_cache_status = FALSE;
    protected $_cache_load   = FALSE;
    protected $_cache_uri;
    protected $_cache_folder;
    protected $_cache_file;
    protected $_cache_path;

    public $cache_expire = 1; /* minutes */

    public function __construct() {
        $Dex = DEX_Dispatcher::getInstance();
        $this->_cache_uri      = $Dex->request->server('REQUEST_URI');
        $this->_cache_folder   = APP_PATH . 'cache' . DIRECTORY_SEPARATOR;
        $this->_cache_file     = md5($this->_cache_uri) . EXT;
        $this->_cache_path     = $this->_cache_folder . $this->_cache_file;
    }

    public function run() {
        $this->_cache_status = TRUE ;
        $cache = $this->read();
        if ( $cache ) {
            $this->_cache_load = TRUE ;
            echo $cache;
            exit();
        } else {
            ob_start();
        }
    }

    public function isOpen() {
        return $this->_cache_status;
    }

    public function isLoad() {
        return $this->_cache_load;
    }

    public function read() {
        if ( ! is_dir($this->_cache_folder) ) {
            error('Error: Unable to write cache file: '. $this->_cache_folder);
            return;
        }

        if ( ! @file_exists($this->_cache_path) ) {
            return FALSE ;
        }

        if ( ! $fp = fopen($this->_cache_path, 'r') ) {
            return FALSE ;
        }

        $expire = time() + ($this->cache_expire * 60);

        $cache = '';
        flock($fp, LOCK_EX);
        if ( filesize($this->_cache_path) > 0 ) {
            $cache = fread($fp, filesize($this->_cache_path));
        }
        flock($fp, LOCK_UN);
        fclose($fp);

        if ( ! preg_match("/(\d+DEXCACHE--->)/", $cache, $match)) {
            return FALSE ;
        }

        $expire_time = trim(str_replace('DEXCACHE--->', '', $match['1']));

        // Has the cache file expired? If so we'll delete it.
        if ( time() >= $expire_time ) {
            @unlink($this->_cache_path);
            return FALSE ;
        }

        return (str_replace($match['0'], '', $cache));
    }


    public function write($output) {
        if ( ! is_dir($this->_cache_folder) ) {
            error('Error: Unable to write cache file: '. $this->_cache_folder);
            return;
        }

        if ( ! $fp = fopen($this->_cache_path, 'w') ) {
            return FALSE ;
        }

        $expire = time() + ($this->cache_expire * 60);

        if ( flock($fp, LOCK_EX) ) {
            fwrite($fp, $expire . 'DEXCACHE--->'. $output );
            flock($fp, LOCK_UN);
        } else {
            error('Error: Unable to secure a file lock for file at: '. $this->_cache_folder);
            return;
        }
        fclose($fp);
    }
}