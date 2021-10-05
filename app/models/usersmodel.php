<?php

namespace FactumMart\API\Models;

class UsersModel extends AbstractModel {

    public static $username;
    public static $email;
    public static $password;
    public static $name;

    protected static $tableName = 'users';
    protected static $tableSchema = [
        'username' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'name' => self::DATA_TYPE_STR
    ];
    protected static $primaryKey = 'id';
    protected static $requiredFields = ['username', 'email', 'password', 'name'];
    protected static $uniqueColumns = ['username', 'email'];

    public function __construct($username = null, $email = null, $password = null, $name = null) {
        self::$username = $username;
        self::$email = $email;
        self::$password = password_hash($password, \PASSWORD_BCRYPT);
        self::$name = $name;
    }

}