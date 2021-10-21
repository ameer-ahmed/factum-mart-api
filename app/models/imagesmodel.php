<?php

namespace FactumMart\API\Models;

class ImagesModel extends AbstractModel {

    public static $real_name;
    public static $name;
    public static $p_id;
    public static $main;

    protected static $tableName = 'images';
    protected static $tableSchema = [
        'real_name' => self::DATA_TYPE_STR,
        'name' => self::DATA_TYPE_STR,
        'p_id' => self::DATA_TYPE_INT,
        'main' => self::DATA_TYPE_BOOL,
    ];
    protected static $primaryKey = 'id';

    public function __construct($real_name = null, $name = null, $p_id = null, $main = null) {
        self::$real_name = $real_name;
        self::$name = $name;
        self::$p_id = $p_id;
        self::$main = $main;
    }

}