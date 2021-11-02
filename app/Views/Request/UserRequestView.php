<?php
namespace App\Views\Request;

use JetBrains\PhpStorm\ArrayShape;

class UserRequestView
{
    /**
     * @return array
     */
    #[ArrayShape(['login' => "string", 'password' => "string"])]
    public static function userDataCollect(): array
    {
        echo 'Введите логин: ';
        $login = readline();

        echo 'Введите пароль: ';
        $pass = readline();

        return ['login' => $login, 'password' => $pass];
    }
}
