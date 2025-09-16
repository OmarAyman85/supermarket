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
//--------------------------------------------------------------------------------
//----------------FETCHING ALL PRODUCTS-------------------------------------------
//--------------------------------------------------------------------------------
    public function getAll() : array {
        $sql = "SELECT p.id AS product_id, p.category_id AS category_id, c.name AS category_name, p.name AS product_name, p.price AS product_price, p.created_at AS product_created_at, c.id AS category_id, c.created_at AS category_created_at 
                FROM products AS p
                JOIN categories AS c
                ON p.category_id = c.id";

        $stmt = $this->conn->query($sql);

        $data = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }

        return $data;
    }
}

?>