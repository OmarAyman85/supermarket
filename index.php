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

$matched = false;

if (isset($router[$requestMethod])) {
    foreach ($router[$requestMethod] as $path => $action) {
        $pathParts = explode('/', trim($path, '/'));
        $uriParts = explode('/', trim($requestUri, '/'));

        if (count($pathParts) !== count($uriParts)) continue;

        $params = [];
        $match = true;

        foreach ($pathParts as $i => $part) {
            if (preg_match('/^{(.+)}$/', $part, $paramMatch)) {
                $params[$paramMatch[1]] = $uriParts[$i];
            } elseif ($part !== $uriParts[$i]) {
                $match = false;
                break;
            }
        }

        if ($match) {
            $controller = new \SuperMarket\Controllers\CategoryController();
            call_user_func_array([$controller, $action], $params);
            $matched = true;
            break;
        }
    }
}

if (!$matched) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Page Not Found'], JSON_PRETTY_PRINT);
}
