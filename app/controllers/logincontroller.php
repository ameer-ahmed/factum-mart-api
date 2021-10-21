<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\LIB\API;
use FactumMart\API\LIB\AppSessionHandler;
use FactumMart\API\Models\SessionsModel;
use FactumMart\API\Models\UsersModel;

class LoginController extends AbstractController {

    public function authAction() {
        $this->activateHeaders('POST');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->catchData();
            $login = new UsersModel();
            $fetchData = @$login->getByCustom('(username = :username  OR email = :email)', ['username' => $data->username, 'email' => $data->email]);
            @$fetchData = (array)$fetchData[0];
            if(count($fetchData) > 0) {
                if(\password_verify($data->password, $fetchData['password'])) {
                    $session = new AppSessionHandler($fetchData['id']);
                    $sessionStart = $session->start();
                    API::response(true, 'Logged in successfully.', [
                        'id' => (int)$fetchData['id'],
                        'username' => $fetchData['username'],
                        'email' => $fetchData['email'],
                        'name' => $fetchData['name'],
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
        } else {
            echo 'Access denied.';
        }
    }

}