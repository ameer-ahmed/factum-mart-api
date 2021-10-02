<?php

if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('APP_PATH', realpath(dirname(__FILE__)));
define('VIEW_PATH', APP_PATH . DS . 'views');


define('NS', 'FactumMart\API');
define('NS_CONTROLLERS', 'FactumMart\API\Controllers\\');

define('NOT_FOUND_CONTROLLER', 'FactumMart\API\Controllers\NotFoundController');

define('NOT_FOUND_ACTION', 'notFoundAction');
