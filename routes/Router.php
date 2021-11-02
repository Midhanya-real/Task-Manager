<?php

namespace Routes;

use App\Controllers\ExitController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use Exception;
use JetBrains\PhpStorm\NoReturn;

/**
 *
 */
class Router
{
    /**
     * @param string $command
     * @return bool
     * @throws Exception
     */

    public static function checkCommand(string $command): bool
    {
        if (!method_exists(self::class, $command) || empty($command)) {
            return false;
        }

        return true;
    }


    /**
     * @return bool
     * @throws Exception
     */
    protected static function register(): bool
    {
        return (new UserController)->register();
    }

    /**
     * @throws Exception
     */
    protected static function auth(): bool
    {
        return (new UserController)->authorization();
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function add(): bool
    {
        return (new TaskController())->post();
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function change(): bool
    {
        return (new TaskController())->put();
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function remove(): bool
    {
        return (new TaskController())->remove();
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function show(): bool
    {
        return (new TaskController())->get();
    }

    #[NoReturn]
    protected static function exit(): void
    {
        (new ExitController())->exitAndClear();
    }


    /**
     * @param string $command
     * @return false
     * @throws Exception
     */

    public function run(string $command): bool
    {
        if (self::checkCommand($command)) {
            return call_user_func([$this, $command]);
        }

        return false;
    }
}