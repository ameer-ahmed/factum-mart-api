<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\Models\UsersModel;

class RegisterController extends AbstractController {

    public function defaultAction() {
        $this->activateHeaders();
        if(
            isset($_POST['username']) &&
            isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['name'])
        ) {
            $missedFields = UsersModel::catchRequiredFields();
            if(count($missedFields)) {
                API::response(\false, 'All fields are required.', ['missed' => $missedFields]);
            } else {
                $register = UsersModel::getInstance([
                    $_POST['username'], 
                    $_POST['email'], 
                    $_POST['password'], 
                    $_POST['name']
                ])->create();
                if($register === true) {
                    API::response(\true, 'User successfully registerd!');
                } else {
                    API::response(\false, 'Something wrong happend.', ['duplicated' => $register]);
                }
            }
        }
    }

}