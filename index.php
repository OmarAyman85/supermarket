<?php

use SuperMarket\Database\Database;
use SuperMarket\Errors\ErrorHandler;

require __DIR__ . '/vendor/autoload.php';

set_exception_handler([ErrorHandler::class, 'handleException']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$database = new Database();
$conn = $database->getConnection();

?>