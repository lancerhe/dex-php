<?php

/**
 * @author Lancer He <lancer.he@gmail.com>
 * @copyright 2011
 */

!defined('DEX') && die('Access denied');

Class Dex_Database {
    private $driver;
    public function __construct() {
        $DEX =& getInstance();
        $DEX->config =& loadClass('Config');
        $DEX->config->load('Database');

        $driver   = $DEX->config->get('DB_type');
        $hostname = $DEX->config->get('DB_host');
        $username = $DEX->config->get('DB_user');
        $password = $DEX->config->get('DB_pass');
        $database = $DEX->config->get('DB_name');

        if (file_exists(SYS_PATH . 'db/' . $driver . '.php')) {
            require_once(SYS_PATH . 'db/' . $driver . '.php');
        } else {
            error('Error: Could not load database file ' . $driver . '!');
        }

        $this->driver = new $driver($hostname, $username, $password, $database);
        $this->tb_prefix = $DEX->config->get('TB_prefix');
    }

    public function query($sql) {
        return $this->driver->query($sql);
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function countAffected() {
        return $this->driver->countAffected();
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }
}
