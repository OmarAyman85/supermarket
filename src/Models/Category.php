<?php
namespace SuperMarket\Models;

use SuperMarket\Database\Database;
use PDO;

class Category{
    private PDO $conn;
    private Database $database;

    public function __construct(){
        $this->database = new Database();
        $this->conn = $this->database->getCOnnection();
    }

//--------------------------------------------------------------------------------
//------------------ADDING A NEW CATEGORY-----------------------------------------
//--------------------------------------------------------------------------------
    public function create(array $data) : int{
        $sql="INSERT INTO categories (name)
              VALUES(:name)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }
//--------------------------------------------------------------------------------
//----------------FETCHING ALL CATEGORIES-----------------------------------------
//--------------------------------------------------------------------------------
    public function getAll() : array {
        $sql = "SELECT *
                FROM categories";

        $stmt = $this->conn->query($sql);

        $data = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }

        return $data;
    }
//--------------------------------------------------------------------------------
//----------------FETCHING A CATEGORY---------------------------------------------
//--------------------------------------------------------------------------------
    public function find(int $id) : array | false {
        $sql = "SELECT *
                FROM categories
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
//--------------------------------------------------------------------------------
//----------------UPDATING A CATEGORY NAME----------------------------------------
//--------------------------------------------------------------------------------
    public function update(array $current, array $new) : int{
        $sql = "UPDATE categories
                SET name = :name
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new['name'] ?? $current['name'], PDO::PARAM_STR);
        $stmt->bindValue(":id", $current['id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
//--------------------------------------------------------------------------------
//----------------DELETING A CATEGORY --------------------------------------------
//--------------------------------------------------------------------------------
    public function destroy(int $id) : int{
        $sql = "DELETE FROM categories
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

}

?>