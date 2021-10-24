<?php

namespace FactumMart\API\Models;

class CategoriesModel extends AbstractModel {

    public $id;
    public $name;
    public $icon;

    protected static $tableName = 'categories';
    protected static $tableSchema = [
        'id' => self::DATA_TYPE_INT,
        'name' => self::DATA_TYPE_STR,
        'icon' => self::DATA_TYPE_STR,
    ];
    protected static $primaryKey = 'id';


    public function __construct($id = \null, $name = \null, $icon = \null) {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
    }

}