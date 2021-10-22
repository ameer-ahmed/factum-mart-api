<?php

namespace FactumMart\API\Models;

class ImagesModel extends AbstractModel {

    public $real_name;
    public $name;
    public $p_id;
    public $main;

    protected static $tableName = 'images';
    protected static $tableSchema = [
        'real_name' => self::DATA_TYPE_STR,
        'name' => self::DATA_TYPE_STR,
        'p_id' => self::DATA_TYPE_INT,
        'main' => self::DATA_TYPE_BOOL,
    ];
    protected static $primaryKey = 'id';

    public function __construct($real_name = null, $name = null, $p_id = null, $main = null) {
        $this->real_name = $real_name;
        $this->name = $name;
        $this->p_id = $p_id;
        $this->main = $main;
    }

}