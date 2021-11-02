<?php

namespace App\Controllers;

use App\Views\Response\ExitResponseView;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

class ExitController
{
    private ExitResponseView $view;

    #[Pure]
    public function __construct()
    {
        $this->view = new ExitResponseView();
    }

    #[NoReturn]
    public function exitAndClear(): void
    {
        $this->view->exit();
    }
}