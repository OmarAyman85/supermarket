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

    // public function create(string $name): bool{
    //     $sql="INSERT INTO categories (name)
    //           VALUES(:name)";

    //     $stmt = $this->conn->prepare($sql);

    //     return $stmt->execute(['name' => $name]);
    // }

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

    // public function getAll() : array {
    //     $sql = "SELECT *
    //             FROM categories";

    //     $stmt = $this->conn->query($sql);

    //     return $stmt->fetchAll();
    // }

//--------------------------------------------------------------------------------
//----------------UPDATING A CATEGORY NAME----------------------------------------
//--------------------------------------------------------------------------------

//--------------------------------------------------------------------------------
//----------------DELETING A CATEGORY --------------------------------------------
//--------------------------------------------------------------------------------

}

?>