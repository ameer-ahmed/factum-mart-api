<?php

namespace FactumMart\API\LIB;

use PDO;

class DB {

    private static $_handler;
    private static $_instance;

    private function __construct() {
        self::init();
    }

    private static function init() {
        self::$_handler = new PDO('mysql://hostname=' . \DB_HOSTNAME . ';dbname=' . \DB_NAME, \DB_USERNAME, \DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_EMULATE_PREPARES => \false,
        ]);
    }

    public static function getInstance() {
        if(self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_handler;
    }

}