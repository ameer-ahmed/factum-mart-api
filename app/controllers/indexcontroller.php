<?php

namespace FactumMart\API\Controllers;

class IndexController extends AbstractController {
    public function defaultAction() {
        $this->_view();
    }
}