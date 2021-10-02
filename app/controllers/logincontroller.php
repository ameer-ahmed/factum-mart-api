<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\Models\UsersModel;

class LoginController extends AbstractController {

    public function authAction() {
        $this->activateHeaders();
        if(isset($_POST['username']) && isset($_POST['password'])) {
            @$login = UsersModel::getInstance()->getByCustom('(username = :username  OR email = :email)', ['username' => $_POST['username'], 'email' => $_POST['email']]);
            if(count($login) > 0) {
                if(\password_verify($_POST['password'], $login[0]->password)) {
                    API::response('success', $this->_action, ['message' => 'Logged in successfully.']);
                } else {
                    API::response('error', $this->_action, ['message' => 'The password is incorrect.']);
                }
            } else {
                API::response('error', $this->_action, ['message' => 'Username or email not found.']);
            }
        }
    }

}