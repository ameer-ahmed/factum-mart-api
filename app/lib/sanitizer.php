<?php

namespace FactumMart\API\LIB;

class Sanitze {

    public static function string($value) {
        return \filter_var($value, \FILTER_SANITIZE_STRING);
    }

    public static function int($value) {
        return \filter_var($value, \FILTER_SANITIZE_NUMBER_INT);
    }

    public static function float($value) {
        return \filter_var($value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);
    }

    public static function email($value) {
        return \filter_var($value, \FILTER_SANITIZE_EMAIL);
    }

    public static function bool($value) {
        if($value === 'true') {
            return \true;
        }
        return \false;
    }

}