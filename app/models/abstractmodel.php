<?php

namespace FactumMart\API\Models;

use FactumMart\API\LIB\DB;
use FactumMart\API\LIB\Sanitze;
use PDO;

class AbstractModel {

    const DATA_TYPE_STR = PDO::PARAM_STR;
    const DATA_TYPE_INT = PDO::PARAM_INT;
    const DATA_TYPE_BOOL = PDO::PARAM_BOOL;
    const DATA_TYPE_DECIMAL = 4;

    private function prepareValues($stmt) {
        foreach(static::$tableSchema as $columnName => $type) {
            if($type === self::DATA_TYPE_STR) {
                $stmt->bindValue(":${columnName}", Sanitze::string($this->$columnName));

            } elseif($type === self::DATA_TYPE_INT) {
                $stmt->bindValue(":${columnName}", Sanitze::int($this->$columnName));

            } elseif($type === self::DATA_TYPE_BOOL) {
                $stmt->bindValue(":${columnName}", Sanitze::bool($this->$columnName));
            }
            elseif($type === 4) {
                $stmt->bindValue(":${columnName}", Sanitze::float($this->$columnName));
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
    }

    public static function getByCustom($where) {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . $where;
        $stmt = DB::getInstance()->prepare($sql);
        if($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \get_called_class(), \array_keys(static::$tableSchema));
        } else {
            return \false;
        }
    }

}