<?php

namespace App\Services;

use App\Models\Task;
use Exception;
use JetBrains\PhpStorm\Pure;

class TaskService
{
    private Task $task;

    #[Pure]
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
        if (FormatService::isFull($taskData)) {
            $flags = FormatService::setFlag(id: null, flag: null, path: $this->task->access());
            $formatData[] = FormatService::collectInFormat(data: $taskData, flags: $flags);

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
        if (FormatService::isFull($newData)) {
            $hasRecord = FileService::hasTask(id: $newData['id'], name: $newData['login'], access: $newData['access'], path: $this->task->access());

            if ($hasRecord) {
                if (key_exists('person', $newData)) {
                    $hasRecord[4] = $newData['person'];
                }

                $flags = FormatService::setFlag(id: null, flag: $newData['id'], path: $this->task->access());
                $unionData = [...$flags, ...$hasRecord];
                $upRecord[] = FormatService::upRecord(data: $unionData, newData: $newData, fields: $this->task->fields());

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
        if (FormatService::isFull($remData)) {
            $hasRecord = FileService::hasTask(id: $remData['id'], name: $remData['login'], access: $remData['access'], path: $this->task->access());

            if ($hasRecord) {
                $flags = FormatService::setFlag(id: 'dell', flag: $remData['id'], path: $this->task->access());
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
            if ($showData['access'] == 'u') {
                if ($showData['login'] == $record['person']) {
                    $result[] = $record;
                }
            } else {
                $result = $clearFile;
            }
        }

        return $result;
    }
}