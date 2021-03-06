<?php

namespace FactumMart\API\Models;

use FactumMart\API\LIB\Sanitize;

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
    protected static $fields = [
        'username' => Sanitize::FILTER_STRING,
        'email' => Sanitize::FILTER_EMAIL,
        'password' => Sanitize::NO_FILTER,
        'name' => Sanitize::FILTER_STRING
    ];
    protected static $requiredFields = [
        'username',
        'email',
        'password',
        'name'
    ];
    protected static $uniqueColumns = [
        'username',
        'email'
    ];

    public function getModelName() {
        return \get_class($this);
    }

    public function __construct($username = null, $email = null, $password = null, $name = null) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, \PASSWORD_BCRYPT);
        $this->name = $name;
    }

}