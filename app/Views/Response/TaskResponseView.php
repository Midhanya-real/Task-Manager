<?php

namespace App\Views\Response;

use App\Services\RecordFormatService;

class TaskResponseView
{
    public static function get(array|bool $showData): bool
    {
        if ($showData) {
            foreach ($showData as $record) {
                RecordFormatService::createOutPattern($record);
            }

            return true;
        }

        return false;
    }

    public static function post(bool $isAdd): bool
    {
        if (!$isAdd) {
            print_r('Не удалось добавить запись' . "\n");
            return false;
        }

        print_r('Запись добавлена' . "\n");
        return true;
    }

    public static function put(bool $isChange): bool
    {
        if (!$isChange) {
            print_r('Не удалось изменить запись' . "\n");
            return false;
        }

        print_r('Запись изменена' . "\n");
        return true;
    }

    public static function remove(bool $isRemove): bool
    {
        if (!$isRemove) {
            print_r('Не удалось удалить запись' . "\n");
            return false;
        }

        print_r('Запись удалена' . "\n");
        return true;
    }
}