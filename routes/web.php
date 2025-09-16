<?php

use SuperMarket\Controllers\CategoryController;
use SuperMarket\Controllers\ProductController;
use SuperMarket\Models\Category;
use SuperMarket\Database\Database;

$database = new Database();
$categoryModel = new Category();
$controller = new CategoryController();

$router = [
    'GET' => [
        '/categories' => [CategoryController::class, 'index'],
        '/categories/{id}' => [CategoryController::class, 'find'],
        '/products' => [ProductController::class, 'index'],
        '/products/{id}' => [ProductController::class, 'find'],
    ],
    'POST' => [
        '/categories' => [CategoryController::class, 'store'],
        '/products'   => [ProductController::class, 'store'],
    ],
    'PUT' => [
        '/categories/{id}' => [CategoryController::class, 'update'],
        '/products/{id}' => [ProductController::class, 'update']
    ],
    'DELETE' => [
        '/categories/{id}' => [CategoryController::class, 'destroy'],
        '/products/{id}' => [ProductController::class, 'destroy']
    ],
];


return $router;
