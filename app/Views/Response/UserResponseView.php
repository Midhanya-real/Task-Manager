<?php

namespace App\Views\Response;

use App\Models\User;

class UserResponseView
{
    public static function register(bool $newUser): bool
    {
        if (!$newUser) {
            print_r('Такой пользователь уже существует' . "\n");
            return false;
        }

        print_r('Регистрация прошла успешно' . "\n");
        return true;

    }

    public function auth(bool $authUser): bool
    {
        if (!$authUser) {
            print_r('Неверно введен логин или пароль. Проверьте введенные данные и попытайтесь снова' . "\n");
            return false;
        }

        print_r('Добро пожаловать в клуб' . "\n");

        return true;
    }

}