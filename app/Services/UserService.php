<?php

namespace App\Services;

use App\Models\User;
use Exception;

class UserService
{
    private User $user;

    public function __construct
    (
        protected string $login,
        protected string $password,
        protected string $status = 'u',
    )
    {
        $this->user = new User();
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    public function auth(): array|bool
    {
        $userData = [$this->login, $this->password];
        $hasUser = false;

        if (RecordFormatService::isFull($userData)) {
            $hasUser = FileService::hasUser(data: $userData, path: $this->user->access());
        }

        if ($hasUser) {
            $user = RecordFormatService::setAssocFormat(data: $hasUser, pattern: $this->user->fields());
            $this->user->setAuth($user);
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function register(): bool
    {
        $userData = [$this->login, $this->password, $this->status];
        $hasUser = true;

        if (RecordFormatService::isFull($userData)) {
            $hasUser = FileService::hasUser(data: $userData, path: $this->user->access());
        }

        if (!$hasUser) {
            return FileService::setData(path: $this->user->access(), data: [$userData]);
        }

        return false;
    }
}