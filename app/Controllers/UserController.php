<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Views\Request\UserRequestView;
use App\Views\Response\UserResponseView;
use Exception;
use JetBrains\PhpStorm\Pure;

class UserController
{

    private UserRequestView $requestView;
    private UserResponseView $responseView;

    #[Pure]
    public function __construct()
    {
        $this->requestView = new UserRequestView();
        $this->responseView = new UserResponseView();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function register(): bool
    {
        $userData = $this->requestView->userDataCollect();
        $newUser = (new UserService($userData['login'], $userData['password']))->register();

        return $this->responseView->register($newUser);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function authorization(): bool
    {
        $userData = $this->requestView->userDataCollect();
        $authUser = (new UserService($userData['login'], $userData['password']))->auth();

        return $this->responseView->auth($authUser);
    }
}

