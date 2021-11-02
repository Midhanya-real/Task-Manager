<?php

namespace App\Services;

use App\Models\User;
use Exception;
use JetBrains\PhpStorm\Pure;

class UserService
{
    private User $user;

    #[Pure]
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

        if (FormatService::isFull($userData)) {
            $hasUser = FileService::hasUser(data: $userData, path: $this->user->access());
        }

        if ($hasUser) {
            return FormatService::setPattern(data: $hasUser, pattern: $this->user->fields());
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

        if (FormatService::isFull($userData)) {
            $hasUser = FileService::hasUser(data: $userData, path: $this->user->access());
        }

        if (!$hasUser) {
            return FileService::setData(path: $this->user->access(), data: [$userData]);
        }

        return false;
    }
}