<?php

namespace FactumMart\API\LIB;

class FrontController {

    private $_controller = 'index';
    private $_action = 'default';
    private $_params = [];

    public function __construct() {
        $this->_parseUrl();
    }

    private function _parseUrl() {
        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'), 3);
        if(isset($url[0]) && $url[0] !== '') {
            $this->_controller = $url[0];
        }
        if(isset($url[1]) && $url[1] !== '') {
            $this->_action = $url[1];
        }
        if(isset($url[2]) && $url[2] !== '') {
            $this->_params = explode('/', $url[2]);
        }
    }

    public function dispatch() {
        $controllerName = \NS_CONTROLLERS . ucfirst($this->_controller) . 'Controller';
        $actionName = $this->_action . 'Action';
        if(!\class_exists($controllerName)) {
            $this->_controller = $controllerName = \NOT_FOUND_CONTROLLER;
        }
        $controller = new $controllerName();
        if(!\method_exists($controller, $actionName)) {
            $this->_action = $actionName = \NOT_FOUND_ACTION;
        }
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->$actionName();
    }
}