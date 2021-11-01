<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\LIB\Sanitize;

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

    protected function catchData() {
        return \json_decode(\file_get_contents('php://input'));
    }

    protected function activateHeaders($method) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Access-Control-Allow-Methods: " . $method);
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    protected function isAuthorizationExisted() {
        $authorization = isset(\getallheaders()['Authorization']) ? \getallheaders()['Authorization'] : '';
        if($authorization !== '') {
            return $authorization;
        }
        return \false;
    }

    protected function paginateProvider($paramIndex, $model, $itemName, $categorized = \false, $categoryId = '') {
        $page = isset($this->_params[$paramIndex]) ? abs(Sanitize::int($this->_params[$paramIndex])) : '';
        if(!empty($page)) {
            $itemsForPage = isset($_GET['items_for_page']) && !empty(Sanitize::int($_GET['items_for_page'])) ? Sanitize::int($_GET['items_for_page']) : '';
            if(!empty(Sanitize::int($itemsForPage)) || Sanitize::int($itemsForPage) > 1) {
                $items = $model;
                $fetchData = $items->getPaginatedItems($itemsForPage, $page, $categorized, $categoryId);
                if(\is_array($fetchData) && \count($fetchData) > 0) {
                    $itemsData = null;
                    foreach($fetchData as $item) {
                        $itemsData[] = $item;
                    }
                    API::response(true, 'Page ' . $page . ' of ' . $items->pagesCount, $itemsData);
                } else {
                    API::response(\false, 'Page ' . $page . ' is out of range.');
                }
            } else {
                API::response(\false, 'Number of ' . $itemName . 's for one page needed to be specified.');
            }
        } else {
            API::response(\false, 'Page number is required.');
        }
    }

    public function notFoundAction() {
        $this->_view();
    }

}