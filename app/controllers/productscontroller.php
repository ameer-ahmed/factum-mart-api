<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\LIB\Sanitize;
use FactumMart\API\Models\ProductsModel;
use FactumMart\API\Models\SessionsModel;

class ProductsController extends AbstractController {

    public function defaultAction() {
        $this->activateHeaders('GET');
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($this->isAuthorizationExisted() && SessionsModel::isSessionExisted($this->isAuthorizationExisted()) > 0) {
                $products = new ProductsModel();
                $fetchData = $products->getAllProducts();
                if(\count($fetchData) > 0) {
                    $productsData = null;
                    foreach($fetchData as $product) {
                        $productsData[] = $product;
                    }
                    API::response(true, null, $productsData);
                }
            } else {
                API::response(\false, 'Not authorized.');
            }
        }
    }

    public function pageAction() {
        $this->activateHeaders('GET');
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($this->isAuthorizationExisted() && SessionsModel::isSessionExisted($this->isAuthorizationExisted()) > 0) {
                $this->paginateProvider(0, new ProductsModel(), 'product');
            } else {
                API::response(\false, 'Not authorized.');
            }
        }
    }

    public function categoryAction() {
        $this->activateHeaders('GET');
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if($this->isAuthorizationExisted() && SessionsModel::isSessionExisted($this->isAuthorizationExisted()) > 0) {
                $category = isset($this->_params[0]) ? abs(Sanitize::int($this->_params[0])) : '';
                if(!empty($category)) {
                    $products = new ProductsModel();
                    if(isset($this->_params[1]) && $this->_params[1] == 'page') {
                        $this->paginateProvider(2, new ProductsModel(), 'product', true, $category);
                    } else {
                        $fetchData = $products->getAllProducts(\true, $category);
                        if(\count($fetchData) > 0) {
                            $productsData = null;
                            foreach($fetchData as $product) {
                                $productsData[] = $product;
                            }
                            API::response(\true, null, $productsData);
                        } else {
                            API::response(\false, 'This category is out of products or not existed.');
                        }
                    }
                } else {
                    API::response(\false, 'Category\'s id is required.');
                }
            } else {
                API::response(\false, 'Not authorized.');
            }
        }
    }

}