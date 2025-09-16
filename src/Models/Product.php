<?php
namespace SuperMarket\Models;

use SuperMarket\Database\Database;
use PDO;

class Product{
    private PDO $conn;
    private Database $database;

    public function __construct(){
        $this->database = new Database();
        $this->conn = $this->database->getConnection();
    }

//-------------------------------------------------------------------------------
//------------------ADDING A NEW PRODUCT-----------------------------------------
//-------------------------------------------------------------------------------
    public function create(array $data) : int {

            $sql = "INSERT INTO products (category_id, name, price)
                VALUES (:category_id, :name, :price)";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(":category_id", $data['category_id'], PDO::PARAM_INT);
            $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
            $stmt->bindValue(":price", $data["price"], PDO::PARAM_STR);
            
            $stmt->execute();

            return $this->conn->lastInsertId();
        
}

}

?>