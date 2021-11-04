<?php

namespace App\Controllers;

use App\Views\Response\ExitResponseView;

class ExitController
{
    private ExitResponseView $view;

    public function __construct()
    {
        $this->view = new ExitResponseView();
    }

    public function exitAndClear(): void
    {
        $this->view->exit();
    }
}