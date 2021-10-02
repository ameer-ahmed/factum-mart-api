<?php

namespace FactumMart\API\Controllers;

class AbstractController {
    
    protected $_controller;
    protected $_action;
    protected $_params;

    protected $_data = [];

    public function setController($controller) {
        $this->_controller = $controller;
    }

    public function setAction($action) {
        $this->_action = $action;
    }

    public function setParams($params) {
        $this->_params = $params;
    }

    protected function _view() {
        if($this->_controller == \NOT_FOUND_CONTROLLER) {
            require_once \VIEW_PATH . DS . 'notfound' . DS . 'notfound.view.php';
        } else {
            $view = \VIEW_PATH . DS . $this->_controller . DS . $this->_action . '.view.php';
            if(\file_exists($view)) {
                \extract($this->_data);
                require_once $view;
            } else {
                require_once \VIEW_PATH . DS . 'notfound' . DS . 'noview.view.php';
            }
        }
    }

    protected function activateHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function notFoundAction() {
        $this->_view();
    }

}