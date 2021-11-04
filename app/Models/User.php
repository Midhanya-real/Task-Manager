<?php

namespace App\Models;

class User
{
    private static string $table = 'app/UserData/users.csv';
    private static array $fields = ['login', 'pass', 'status'];
    private static array $authStatus = [];

    public function access(): string
    {
        return self::$table;
    }

    public function fields(): array
    {
        return self::$fields;
    }

    public function setAuth(array $userData): bool
    {
        self::$authStatus = $userData;

        return true;
    }

    public function isAuth(): array
    {
        return self::$authStatus;
    }
}