<?php
namespace SuperMarket\Models;

use SuperMarket\Database\Database;
use PDO;

class Category{
    private PDO $conn;

    public function __construct(Database $database){
        $this->conn = $database->getCOnnection();
    }

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

    
}

?>