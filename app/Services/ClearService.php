<?php

namespace App\Services;

use App\Models\Task;
use JetBrains\PhpStorm\Pure;


class ClearService
{
    private Task $task;

    #[Pure]
    public function __construct()
    {
        $this->task = new Task();
    }

    private static function isDeleted(string $path, array $fields): array
    {
        $userFile = FileService::getData($path);
        $deleted = [];

        foreach ($userFile as $record) {
            $record = FormatService::setPattern(data: $record, pattern: $fields);

            if ($record['flag'] != 0) {
                $deleted[] = $record['flag'];
            }
        }

        return $deleted;
    }

    private static function sort(string $path, array $data, array $fields): array
    {
        $userFile = FileService::getData($path);
        $sorted = [];

        foreach ($userFile as $record) {
            $record = FormatService::setPattern(data: $record, pattern: $fields);
            if (!in_array($record['id'], $data) && $record['id'] != 'dell') {
                $sorted[] = $record;
            }
        }

        return $sorted;
    }

    public function getClearFile(): array
    {
        $delRecord = self::isDeleted(path: $this->task->access(),fields: $this->task->fields());

        return self::sort(path: $this->task->access(), data: $delRecord,fields: $this->task->fields());
    }

    public function setClearFile(): bool
    {
        $formatData = [];
        $clearFile = self::getClearFile();
        FileService::setClear($this->task->access());

        foreach ($clearFile as $record) {
            $record = array_splice($record, 2);
            $flags = FormatService::setFlag(id: null, flag: null, path: $this->task->access());
            $formatData[] = FormatService::collectInFormat(data: $record, flags: $flags);

            FileService::setData(path: $this->task->access(), data: $formatData, access: 'w+');
        }

        return true;
    }

}