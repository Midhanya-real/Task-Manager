<?php

namespace App\Services;

use App\Models\Task;
use Exception;

class TaskService
{
    private Task $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    /**
     * @param array $taskData
     * @return bool
     * @throws Exception
     */

    public function add(array $taskData): bool
    {
        if (RecordFormatService::isFull($taskData)) {
            $flags = RecordFormatService::setFlags(id: null, flag: null, path: $this->task->access());
            $formatData[] = RecordFormatService::collectInStrFormat(data: $taskData, flags: $flags);

            return FileService::setData(path: $this->task->access(), data: $formatData);
        }

        return false;
    }

    /**
     * @param array $newData
     * @return bool
     * @throws Exception
     */
    public function change(array $newData): bool
    {
        if (RecordFormatService::isFull($newData)) {
            $hasRecord = FileService::hasTask(id: $newData['id'], name: $newData['login'], access: $newData['access'], path: $this->task->access());

            if ($hasRecord) {
                if (key_exists('person', $newData)) {
                    $hasRecord[4] = $newData['person'];
                }

                $flags = RecordFormatService::setFlags(id: null, flag: $newData['id'], path: $this->task->access());
                $unionData = [...$flags, ...$hasRecord];
                $upRecord[] = RecordFormatService::upContent(data: $unionData, newData: $newData, fields: $this->task->fields());

                return FileService::setData(path: $this->task->access(), data: $upRecord);
            }
        }

        return false;
    }

    /**
     * @param array $remData
     * @return bool
     * @throws Exception
     */
    public function remove(array $remData): bool
    {
        if (RecordFormatService::isFull($remData)) {
            $hasRecord = FileService::hasTask(id: $remData['id'], name: $remData['login'], access: $remData['access'], path: $this->task->access());

            if ($hasRecord) {
                $flags = RecordFormatService::setFlags(id: 'dell', flag: $remData['id'], path: $this->task->access());
                $unionData[] = [...$flags, ...$hasRecord];

                return FileService::setData(path: $this->task->access(), data: $unionData);
            }

        }
        return false;
    }

    public function show(array $showData): array
    {
        $clearFile = (new ClearService)->getClearFile();
        $result = [];

        foreach ($clearFile as $record) {
            if ($showData['access'] == 'a') {
                $result = $clearFile;
            } else {
                if ($showData['login'] == $record['person']) {
                    $result[] = $record;
                }
            }
        }

        return $result;
    }
}