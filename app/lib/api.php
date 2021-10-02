<?php

namespace FactumMart\API\LIB;

class API {

    private static $_instance;

    public function __construct($status, $actionName, $responseData = []) {
        echo \json_encode([
            "status" => "${status}",
            $actionName => $responseData,
        ]);
    }

    public static function response($status, $actionName, $responseData) {
        if(self::$_instance === null) {
            self::$_instance = new self($status, $actionName, $responseData);
        }
    }
}