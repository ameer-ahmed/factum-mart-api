<?php

namespace FactumMart\API\Models;

use FactumMart\API\LIB\DB;
use FactumMart\API\LIB\Sanitize;
use PDO;

class ProductsModel extends AbstractModel {

    public $id;
    public $name;
    public $price;
    public $old_price;
    public $unique_name;

    protected static $tableName = 'products';
    protected static $joindTables = ['images'];
    protected static $tableSchema = [
        'name' => self::DATA_TYPE_STR,
        'price' => self::DATA_TYPE_DECIMAL,
        'old_price' => self::DATA_TYPE_DECIMAL,
        'unique_name' => self::DATA_TYPE_STR,
    ];
    protected static $primaryKey = 'id';

    public function __construct($id = null, $name = null, $price = null, $old_price = null, $unique_name = null) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->old_price = $old_price;
        $this->unique_name = $unique_name;
    }

    public function getAllProducts() {
        $sql = 'SELECT products.id, products.name, products.price, products.old_price, images.unique_name FROM products JOIN images ON products.id = images.p_id';
        $stmt = DB::getInstance()->prepare($sql);
        if($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \get_called_class());
        } else {
            return \false;
        }
    }

    public function getPaginatedProducts($productsForPage, $page) {
        if(
            !empty(Sanitize::int($page)) && 
            (int)Sanitize::int($page > 0)
        ) {
            $sql = 'SELECT products.id, products.name, products.price, products.old_price, images.unique_name FROM products JOIN images ON products.id = images.p_id WHERE products.id >= ' . $this->paginate($productsForPage)[$page]['first'] . ' AND products.id <= ' . $this->paginate($productsForPage)[$page]['last'];
            $stmt = DB::getInstance()->prepare($sql);
            if($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \get_called_class());
            } else {
                return \false;
            }
        }    
    }
}