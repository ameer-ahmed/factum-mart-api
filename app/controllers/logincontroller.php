<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\LIB\AppSessionHandler;
use FactumMart\API\Models\UsersModel;

class LoginController extends AbstractController {

    public function authAction() {
        $this->activateHeaders();
        if(isset($_POST['username']) && isset($_POST['password'])) {
            @$login = UsersModel::getInstance()->getByCustom('(username = :username  OR email = :email)', ['username' => $_POST['username'], 'email' => $_POST['email']]);
            @$login = (array)$login[0];
            if(count($login) > 0) {
                if(\password_verify($_POST['password'], $login['password'])) {
                    $session = new AppSessionHandler($login['id']);
                    API::response(true, 'Logged in successfully.', [
                        'id' => $login['id'],
                        'name' => $login['name'],
                        'email' => $login['email'],
                        'token' => $session->start(),
                    ]);
                } else {
                    API::response(false, 'The password is incorrect');
                }
            } else {
                API::response(false, 'Username or email not found.');
            }
        }
    }

}