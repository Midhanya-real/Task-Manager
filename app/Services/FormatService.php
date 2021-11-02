<?php

namespace App\Services;

use App\Models\Task;
use Exception;
use JetBrains\PhpStorm\Pure;

class FormatService
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

    public static function setFlag(string|null $id, string|null $flag, string $path): array
    {
        if ($id == null) {
            $id = count(file($path)) + 1 . 'xt';
        }
        if ($flag == null) {
            $flag = '0';
        }

        return [$id, $flag];
    }

    public static function setFormat(array $data): array
    {
        $newFormat = [];
        foreach ($data as $value) {
            $newFormat[] = (string)$value;
        }

        return $newFormat;
    }

    public static function collectInFormat(array $data, array $flags): array
    {
        $valData = array_values($data);
        $valFlags = array_values($flags);
        return self::setFormat([...$valFlags, ...$valData]);
    }

    public static function setPattern(array $data, array $pattern): array
    {
        return array_combine($pattern, $data);
    }

    /**
     * @param array $data
     * @param array $newData
     * @param array $fields
     * @return array
     */
    #[Pure]
    public static function upRecord(array $data, array $newData, array $fields): array
    {
        $record = self::setPattern(data: $data, pattern: $fields);

        foreach ($newData as $key => $value) {
            if (key_exists($key, $record)) {
                if (!is_null($key) && $key != 'id') {
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