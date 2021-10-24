<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\Models\CategoriesModel;
use FactumMart\API\Models\SessionsModel;

class CategoriesController extends AbstractController {

    public function defaultAction() {
        $this->activateHeaders('GET');
        if($this->isAuthorizationExisted() && SessionsModel::isSessionExisted($this->isAuthorizationExisted()) > 0) {
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                $categories = new CategoriesModel();
                $fetchData = $categories->getAll();
                $fetchData = isset($fetchData) ? (array)$fetchData : [];
                if(\count($fetchData) > 0) {
                    API::response(\true, null, $fetchData);
                } else {
                    API::response(\false, 'No categories have been added yet.');
                }
            }
        } else {
            API::response(\false, 'Not Authorized.');
        }
    }

}