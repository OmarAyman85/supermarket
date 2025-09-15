<?php

use SuperMarket\Database\Database;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
echo "I AM HERE 1 \n";

$database = new Database();
$conn = $database->getConnection();


?>