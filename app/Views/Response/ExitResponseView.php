<?php

namespace App\Views\Response;

use App\Services\ClearService;

class ExitResponseView
{
    private ClearService $service;

    public function __construct()
    {
        $this->service = new ClearService();
    }

    public function exit()
    {
        $this->service->setClearFile();
        exit();
    }
}