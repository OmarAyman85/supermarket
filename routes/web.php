<?php

use SuperMarket\Controllers\CategoryController;
use SuperMarket\Models\Category;
use SuperMarket\Database\Database;

$database = new Database();
$categoryModel = new Category();
$controller = new CategoryController();

$router = [
    'GET' => [
        '/categories' => 'index',          
        '/categories/{id}' => 'find',      
    ],
    'POST' => [
        '/categories' => 'store',          
    ],
];


return $router;
