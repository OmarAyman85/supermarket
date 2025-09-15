<?php

use SuperMarket\Controllers\CategoryController;
use SuperMarket\Models\Category;
use SuperMarket\Database\Database;

$database = new Database();
$categoryModel = new Category();
$controller = new CategoryController();

$router = [
    'GET' => [
        '/categories' => fn() => $controller->index(),
    ],
    'POST' => [
        '/categories' => fn() => $controller->store(
            (array) json_decode(file_get_contents('php://input'), true)
        ),
    ],
];

return $router;
