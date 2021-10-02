<?php

namespace FactumMart\API\Models;

use FactumMart\API\LIB\DB;
use FactumMart\API\LIB\Sanitize;
use PDO;

class AbstractModel {

    const DATA_TYPE_STR = PDO::PARAM_STR;
    const DATA_TYPE_INT = PDO::PARAM_INT;
    const DATA_TYPE_BOOL = PDO::PARAM_BOOL;
    const DATA_TYPE_DECIMAL = 4;

    private static $_instance;

    public static function getInstance() {
        if(self::$_instance === null) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    private function prepareValues($stmt, $values = []) {
        if(\count($values) > 0) {
            foreach($values as $columnName => $value) {
                $stmt->bindValue(":${columnName}", Sanitize::string($value));
            }
        } else {
            foreach(static::$tableSchema as $columnName => $type) {
                if($type === self::DATA_TYPE_STR) {
                    $stmt->bindValue(":${columnName}", Sanitize::string($this->$columnName));
    
                } elseif($type === self::DATA_TYPE_INT) {
                    $stmt->bindValue(":${columnName}", Sanitize::int($this->$columnName));
    
                } elseif($type === self::DATA_TYPE_BOOL) {
                    $stmt->bindValue(":${columnName}", Sanitize::bool($this->$columnName));
                }
                elseif($type === 4) {
                    $stmt->bindValue(":${columnName}", Sanitize::float($this->$columnName));
                }
            }
        }
    }

    private static function buildNamedSQLParameters() {
        $namedParams = '';
        foreach(static::$tableSchema as $columnName => $type) {
            $namedParams .= $columnName . ' = :' . $columnName .', ';
        }
        return \trim($namedParams, ', ');
    }

    public static function getByPK($pk) {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = "' . $pk . '"';
        // TODO: To be continued.
    }

    public function getByCustom($where, $values) {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . $where;
        $stmt = DB::getInstance()->prepare($sql);
        $this->prepareValues($stmt, $values);
        if($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \get_called_class(), \array_keys(static::$tableSchema));
        } else {
            return \false;
        }
    }

}