<?php

namespace App\Services;

class FileService
{
    public static function checkFiles(): bool
    {
        if (!file_exists('app/UserData')) {
            mkdir('app/UserData');
        }

        if (!file_exists('app/UserData/users.csv')) {
            touch('app/UserData/users.csv');
        }
        if (!file_exists('app/UserData/tasks.csv')) {
            touch('app/UserData/tasks.csv');
        }

        return true;
    }

    public static function setClear(string $path)
    {
        $file = fopen($path, 'w+');
        fclose($file);
    }

    public static function setData(string $path, array $data, string $access = 'a+'): bool
    {
        $usersFile = fopen($path, $access);
        foreach ($data as $value) {
            fputcsv($usersFile, $value);
        }
        fclose($usersFile);

        return true;
    }

    public static function getData(string $path): \Generator
    {
        $usersFile = fopen($path, 'r');

        while (($line = fgetcsv($usersFile))) {
            yield $line;
        }

        fclose($usersFile);
    }

    public static function hasTask(string $id, string $name, string $access, string $path): bool|array
    {
        $records = self::getData($path);

        foreach ($records as $record) {
            if ($access == 'a') {
                if (in_array($id, $record)) {
                    return array_splice($record, 2);
                }
            } else {
                if (in_array($id, $record) && in_array($name, $record)) {
                    return array_splice($record, 2);
                }
            }
        }

        return false;
    }

    public static function hasUser(array $data, string $path): array|false
    {
        $userRecords = self::getData($path);
        $data = array_slice($data, 0, 2);

        foreach ($userRecords as $value) {
            $formatLine = array_slice($value, 0, 2);
            if ($formatLine === $data) {
                return $value;
            }
        }

        return false;
    }
}