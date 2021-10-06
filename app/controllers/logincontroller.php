<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\LIB\AppSessionHandler;
use FactumMart\API\Models\SessionsModel;
use FactumMart\API\Models\UsersModel;

class LoginController extends AbstractController {

    public function authAction() {
        $this->activateHeaders();
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $login = new UsersModel();
            $fetchData = @$login->getByCustom('(username = :username  OR email = :email)', ['username' => $_POST['username'], 'email' => $_POST['email']]);
            @$fetchData = (array)$fetchData[0];
            if(count($fetchData) > 0) {
                if(\password_verify($_POST['password'], $fetchData['password'])) {
                    $session = new AppSessionHandler($fetchData['id']);
                    $sessionStart = $session->start();
                    API::response(true, 'Logged in successfully.', [
                        'id' => $fetchData['id'],
                        'name' => $fetchData['name'],
                        'email' => $fetchData['email'],
                        'token' => $sessionStart,
                    ]);
                    $session = new SessionsModel($fetchData['id'], $sessionStart, \time());
                    $session->create();
                } else {
                    API::response(false, 'The password is incorrect');
                }
            } else {
                API::response(false, 'Username or email not found.');
            }
        }
    }

}