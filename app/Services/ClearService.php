<?php

namespace App\Services;

use App\Models\Task;


class ClearService
{
    private Task $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    private static function collectDeleted(string $path, array $fields): array
    {
        $userFile = FileService::getData($path);
        $deleted = [];

        foreach ($userFile as $record) {
            $record = RecordFormatService::setAssocFormat(data: $record, pattern: $fields);

            if ($record['flag'] != 0) {
                $deleted[] = $record['flag'];
            }
        }

        return $deleted;
    }

    private static function sortFile(string $path, array $data, array $fields): array
    {
        $userFile = FileService::getData($path);
        $sorted = [];

        foreach ($userFile as $record) {
            $record = RecordFormatService::setAssocFormat(data: $record, pattern: $fields);
            if (!in_array($record['id'], $data) && $record['id'] != 'dell') {
                $sorted[] = $record;
            }
        }

        return $sorted;
    }

    public function getClearFile(): array
    {
        $delRecord = self::collectDeleted(path: $this->task->access(),fields: $this->task->fields());

        return self::sortFile(path: $this->task->access(), data: $delRecord,fields: $this->task->fields());
    }

    public function setClearFile(): bool
    {
        $rewrittenData = [];
        $clearFile = self::getClearFile();
        FileService::setClear($this->task->access());

        foreach ($clearFile as $record) {
            $record = array_splice($record, 2);
            $flags = RecordFormatService::setFlags(id: null, flag: null, path: $this->task->access());
            $rewrittenData[] = RecordFormatService::collectInStrFormat(data: $record, flags: $flags);

            FileService::setData(path: $this->task->access(), data: $rewrittenData, access: 'w+');
        }

        return true;
    }

}