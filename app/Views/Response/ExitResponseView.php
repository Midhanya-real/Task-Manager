<?php

namespace App\Views\Response;

use App\Services\ClearService;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

class ExitResponseView
{
    private ClearService $service;

    #[Pure]
    public function __construct()
    {
        $this->service = new ClearService();
    }

    #[NoReturn]
    public function exit()
    {
        $this->service->setClearFile();
        exit();
    }
}