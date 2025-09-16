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
//--------------------------------------------------------------------------------
//----------------FETCHING A PRODUCT----------------------------------------------
//--------------------------------------------------------------------------------
    public function find(int $id) : array | false {
        $sql = "SELECT *
                FROM products
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
//--------------------------------------------------------------------------------
//----------------UPDATING A PRODUCT----------------------------------------------
//--------------------------------------------------------------------------------
    public function update (array $current, array $new) : int {
        $sql = "UPDATE products
                SET name = :name, price = :price, category_id = :category_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new['name'] ?? $current['name'], PDO::PARAM_STR);
        $stmt->bindValue(":price", $new['price'] ?? $current['price'], PDO::PARAM_INT);
        $stmt->bindValue(":category_id", $new['category_id'] ?? $current['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(":id", $current['id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
//--------------------------------------------------------------------------------
//----------------DELETING A PRODUCT ---------------------------------------------
//--------------------------------------------------------------------------------
    public function destroy(int $id) : int{
        $sql = "DELETE FROM products
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}

?>