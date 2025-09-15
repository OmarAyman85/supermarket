<?php

use SuperMarket\Database\Database;
use SuperMarket\Errors\ErrorHandler;
use SuperMarket\Models\Category;
use SuperMarket\Controllers\CategoryController;

require __DIR__ . '/vendor/autoload.php';

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$database = new Database();
// $conn = $database->getConnection();

$categoryModel = new Category($database);

$categoryController = new CategoryController($categoryModel);

$categoryController->store(["name" => 'ELECTRONICS']);
$categoryController->index();

echo "\n";
?>