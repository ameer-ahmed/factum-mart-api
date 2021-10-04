<?php

namespace FactumMart\API\LIB;

class API {

    private static $_instance;

    public function __construct($status, $message, $responseData = []) {
        echo \json_encode([
            "status" => $status,
            "message" => $message,
            "data" => $responseData,
        ]);
    }

    public static function response($status, $message, $responseData = null) {
        if(self::$_instance === null) {
            self::$_instance = new self($status, $message, $responseData);
        }
    }
}