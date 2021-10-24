<?php

if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('APP_PATH', realpath(dirname(__FILE__)));
define('VIEW_PATH', APP_PATH . DS . 'views');
define('SESSIONS_SAVE_PATH', APP_PATH . DS . 'sessions');
define('IMAGES_PATH', APP_PATH . DS . 'media' . DS . 'images');
define('ASSETS_PATH', APP_PATH . DS . 'assets');




define('NS', 'FactumMart\API');
define('NS_CONTROLLERS', 'FactumMart\API\Controllers\\');

define('NOT_FOUND_CONTROLLER', 'FactumMart\API\Controllers\NotFoundController');

define('NOT_FOUND_ACTION', 'notFoundAction');

define('DB_HOSTNAME', 'localhost');
define('DB_NAME', 'factum_mart');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');