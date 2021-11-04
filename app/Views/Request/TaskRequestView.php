<?php

namespace App\Views\Request;

use App\Models\User;
use Exception;

class TaskRequestView
{
    /**
     * @throws Exception
     */
    private array $authStatus;

    public function __construct()
    {
        $this->authStatus = (new User())->isAuth();
    }

    /**
     * @return array|false
     */
    public function postDataCollection(): array|bool
    {
        if ($this->authStatus) {
            echo 'введите заголовок: ';
            $head = readline();

            echo 'введите описание: ';
            $about = readline();

            echo 'введите дату исполнения(дд.мм.гг): ';
            $date = readline();

            echo 'введите статус выполнения(исполняется, выполнено, отложено): ';
            $status = readline();

            $person = $this->authStatus['login'];

            if ($this->authStatus['status'] == 'a') {
                echo 'Введите исполняемое лицо: ';
                $person = readline();

            }

            return ['head' => $head, 'about' => $about, 'date' => $date, 'status' => $status, 'person' => $person];
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function putDataCollection(): array|bool
    {
        if ($this->authStatus) {
            echo 'Введите номер редактируемой записи: ';
            $id = readline();

            echo 'введите статус выполнения(исполняется, выполнено, отложено): ';
            $status = readline();

            $changeData = ['id' => $id, 'status' => $status, 'login' => $this->authStatus['login'], 'access' => $this->authStatus['status']];

            if ($this->authStatus['status'] == 'a') {
                echo 'Введите исполняемое лицо: ';
                $person = readline();

                $changeData['person'] = $person;
            }

            return $changeData;
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function removeDataCollection(): array|bool
    {
        if ($this->authStatus) {
            echo 'Введите номер задачи, которую хотели бы удалить: ';
            $taskId = readline();

            return ['id' => $taskId, 'login' => $this->authStatus['login'], 'access' => $this->authStatus['status']];
        }

        return false;
    }

    public function getDataCollection(): array|bool
    {
        if ($this->authStatus) {
            return ['login' => $this->authStatus['login'], 'access' => $this->authStatus['status']];
        }

        return false;
    }
}