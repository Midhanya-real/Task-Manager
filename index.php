<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Services\FileService;
use Routes\Router;

FileService::checkFiles();

$router = Router::getInstance();

while (true) {
    $command = readline();

    $router->run($command);
}


