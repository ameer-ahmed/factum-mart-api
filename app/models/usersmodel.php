<?php

namespace FactumMart\API\Models;

class UsersModel extends AbstractModel {

    public $username;
    public $email;
    public $password;
    public $name;

    protected static $tableName = 'users';
    protected static $tableSchema = [
        'username' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'name' => self::DATA_TYPE_STR
    ];
    protected static $primaryKey = 'id';

}