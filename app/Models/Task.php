<?php

namespace App\Models;

class Task
{
    private static string $table = 'app/UserData/tasks.csv';
    private static array $fields = ['id', 'flag', 'head', 'about', 'date', 'status', 'person'];

    public function access(): string
    {
        return self::$table;
    }

    public function fields(): array
    {
        return self::$fields;
    }
}