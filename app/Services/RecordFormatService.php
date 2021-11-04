<?php

namespace App\Services;

use Exception;

class RecordFormatService
{
    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function isFull(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                throw new Exception($key . " is not set");
            }
        }

        return true;
    }

    public static function setFlags(string|null $id, string|null $flag, string $path): array
    {
        if ($id == null) {
            $id = count(file($path)) + 1 . 'xt';
        }
        if ($flag == null) {
            $flag = '0';
        }

        return [$id, $flag];
    }

    public static function setStrFormat(array $data): array
    {
        $strFormat = [];
        foreach ($data as $value) {
            $strFormat[] = (string)$value;
        }

        return $strFormat;
    }

    public static function collectInStrFormat(array $data, array $flags): array
    {
        $valData = array_values($data);
        $valFlags = array_values($flags);
        return self::setStrFormat([...$valFlags, ...$valData]);
    }

    public static function setAssocFormat(array $data, array $pattern): array
    {
        return array_combine($pattern, $data);
    }

    /**
     * @param array $data
     * @param array $newData
     * @param array $fields
     * @return array
     */
    public static function upContent(array $data, array $newData, array $fields): array
    {
        $record = self::setAssocFormat(data: $data, pattern: $fields);

        foreach ($newData as $key => $value) {
            if (key_exists($key, $record)) {
                if ($key != 'id') {
                    $record[$key] = $value;
                }
            }
        }

        return $record;
    }

    public static function createOutPattern(array $data)
    {
        print_r(
            "\n" . '*******************************' . "\n" .
            'Номер задачи' . ' => ' . $data['id'] . "\n" .
            'Заголовок' . ' => ' . $data['head'] . "\n" .
            'Описание' . ' => ' . $data['about'] . "\n" .
            'Дата' . ' => ' . $data['date'] . "\n" .
            'Статус' . ' => ' . $data['status'] . "\n" .
            'Исполнитель' . ' => ' . $data['person'] . "\n" .
            '*******************************' . "\n"
        );
    }
}