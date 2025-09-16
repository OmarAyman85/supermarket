<?php

namespace SuperMarket\Helpers;

use SuperMarket\Database\Database;
use PDO;

class Validator{
    private PDO $conn;
    private Database $database;

    public function __construct(){
        $this->database = new Database();
        $this->conn = $this->database->getConnection();
    }

    public function getCategoryValidationError(array $data) : array{
        $errors = [];
        if (empty($data["name"])){
            $errors[] = "name is required!";
        }

        return $errors;
    }

    public function categoryExistanceValidation(array $data) : array {
        $errors = [];

        $sql_1 = "SELECT EXISTS (
                    SELECT 1
                    FROM categories
                    WHERE id = :category_id)
                    AS category_exists;";

        $stmt_1 = $this->conn->prepare($sql_1);

        $stmt_1->bindValue(":category_id", $data['category_id'], PDO::PARAM_INT);

        $stmt_1->execute();
        
        $category_exists = (bool) $stmt_1->fetchColumn();

        if(!$category_exists){
            $errors[] = "Category with the id: " . $data['category_id'] . " does not exist";
        }

        return $errors;
    }

    public function getProductValidationError(array $data) : array {
        $errors = [];
        //name validation
        if(empty($data['name'])){
            $errors[] = "name is required!";
        }

        //price validation
        if(empty($data['price'])){
            $errors[] = "price is required!";
        }

        if(!is_numeric($data['price'])){
            $errors[] = "Price must be number!";
        }

        if($data['price'] <= 0){
            $errors[] = "Price need to be more than 0!";
        }

        return $errors;
    }
    
}
?>