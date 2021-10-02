<?php

namespace FactumMart\API\Controllers;

use PDO;

class IndexController extends AbstractController {
    public function defaultAction() {
        $this->_view();
    }
}