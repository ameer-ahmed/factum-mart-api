<?php

namespace FactumMart\API\Controllers;

use FactumMart\API\Models\UsersModel;

class LoginController extends AbstractController {

    public function authAction() {

        @$login = UsersModel::getByCustom('(username = "' . $this->_params[0] . '" OR email = "' . $this->_params[0] . '")');
        if(count($login) > 0) {
            $this->_data['user'] = \json_encode('true');
        } else {
            $this->_data['user'] = \json_encode('false');
        }
        $this->_view();
    }

}