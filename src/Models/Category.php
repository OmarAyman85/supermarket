<?php
namespace SuperMarket\Models;

use SuperMarket\Database\Database;
use SuperMarket\Helpers\Logger;
use SuperMarket\Helpers\Uploader;
use PDO;

class Category{
    private PDO $conn;
    private Database $database;

    use Logger;
    use Uploader;

    public function __construct(){
        $this->database = new Database();
        $this->conn = $this->database->getCOnnection();
    }

//--------------------------------------------------------------------------------
//------------------ADDING A NEW CATEGORY-----------------------------------------
//--------------------------------------------------------------------------------
    public function create(array $data) : int{

        $imagePath = $this->uploadImage('image', 'Categories');

        $sql="INSERT INTO categories (name, image)
              VALUES(:name, :image)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":image", $imagePath, PDO::PARAM_STR);

        $stmt->execute();

        $category_Id = $this->conn->lastInsertId();

        $this->logEvent("NEW CATEGORY ADDED WITH THE ID : $category_Id");

        return $category_Id;
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

        $this->logEvent("FETCHING ALL CATEGORIES IS REQUESTED ...");

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

        $this->logEvent("CATEGORY WITH THE ID : $id IS FETCHED.");

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

        $this->logEvent("CATEGORY WITH THE ID : {$current['id']} IS UPDATED.");

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

        $this->logEvent("CATEGORY WITH THE ID : $id IS DELETED.");

        return $stmt->rowCount();
    }

}

?>