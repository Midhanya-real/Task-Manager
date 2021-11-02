<?php

namespace App\Models;

class User
{
    private static string $table = 'app/UserData/users.csv';
    private static array $fields = ['login', 'pass', 'status'];
    private static array $authStatus = [];

    public static function access(): string
    {
        return self::$table;
    }

    public static function fields(): array
    {
        return self::$fields;
    }

    public static function setAuth(array $userData): bool
    {
        self::$authStatus = $userData;

        return true;
    }

    public static function isAuth(): array
    {
        return self::$authStatus;
    }

    public static function isAdmin(): bool
    {
        if (self::$authStatus['status'] != 'a') {
            return false;
        }

        return true;
    }
}