<?php

namespace FactumMart\API\Models;

class UsersModel extends AbstractModel {

    protected $username;
    protected $email;
    protected $password;
    protected $name;

    protected static $tableName = 'users';
    protected static $tableSchema = [
        'username' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'name' => self::DATA_TYPE_STR
    ];
    protected static $primaryKey = 'id';

    public function __construct($username, $email, $password, $name) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

}