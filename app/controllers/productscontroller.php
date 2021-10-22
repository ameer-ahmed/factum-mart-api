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
                @$page = !empty($this->_params[0]) ? abs(Sanitize::int($this->_params[0])) : '';
                if(!empty($page)) {
                    $productsForPage = $this->catchData()->productsForPage;
                    if(!empty(Sanitize::int($productsForPage)) || Sanitize::int($productsForPage) > 1) {
                        $products = new ProductsModel();
                        $fetchData = @$products->getPaginatedProducts($productsForPage, $page);
                        if(\is_array($fetchData) && \count($fetchData) > 0) {
                            $productsData = null;
                            foreach($fetchData as $product) {
                                $productsData[] = $product;
                            }
                            API::response(true, 'Page ' . $page . ' of ' . $products->pagesCount, $productsData);
                        } else {
                            API::response(\false, 'Page ' . $page . ' is out of range.');
                        }
                    } else {
                        API::response(\false, 'Number of products for one page needed to be specified.');
                    }
                } else {
                    API::response(\false, 'Page number is requested.');
                }
            } else {
                API::response(\false, 'Not authorized.');
            }
        }
    }

}