<?php

use SuperMarket\Errors\ErrorHandler;

require __DIR__ . '/vendor/autoload.php';

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$router = require __DIR__ . '/routes/web.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($router[$requestMethod][$requestUri])) {
    $router[$requestMethod][$requestUri]();
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Page Not Found']);
}