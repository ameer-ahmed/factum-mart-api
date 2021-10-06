<?php

namespace FactumMart\API\LIB;

class Sanitize {

    const FILTER_STRING = 'string';
    const FILTER_INT = 'int';
    const FILTER_FLOAT = 'float';
    const FILTER_EMAIL = 'email';
    const FILTER_BOOL = 'bool';
    const NO_FILTER = null;

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