<?php

namespace FactumMart\API\Models;

use FactumMart\API\LIB\DB;

class SessionsModel extends AbstractModel {

    public static $user_id;
    public static $session_token;
    public static $start_timestamp;

    
    protected static $tableName = 'sessions';
    protected static $tableSchema = [
        'user_id' => self::DATA_TYPE_INT,
        'session_token' => self::DATA_TYPE_STR,
        'start_timestamp' => self::DATA_TYPE_INT
    ];
    protected static $primaryKey = 'id';

    protected static $uniqueColumns = ['session_token'];

    public function getModelName() {
        return \get_class($this);
    }

    public static function isSessionExisted($token) {
        $sql = "SELECT " . self::$tableName . "." . self::$primaryKey . " FROM " . self::$tableName . " WHERE " . self::$uniqueColumns[0] . " = :" . self::$uniqueColumns[0];
        $stmt = DB::getInstance()->prepare($sql);
        parent::prepareValues($stmt, [self::$uniqueColumns[0] => $token]);
        if($stmt->execute()) {
            return $stmt->rowCount();
        }
        return \false;
    }

    public function __construct($user_id, $session_token, $start_timestamp) {
        self::$user_id = $user_id;
        self::$session_token = $session_token;
        self::$start_timestamp = $start_timestamp;
    }

}