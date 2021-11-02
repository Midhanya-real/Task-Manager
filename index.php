<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Services\FileService;
use Routes\Router;

FileService::checkFiles();

while (true) {
    echo memory_get_usage() . "\n";
    $command = readline();

    (new Router())->run($command);
    echo memory_get_usage() . "\n";
}
