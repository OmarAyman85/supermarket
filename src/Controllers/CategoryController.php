<?php
namespace SuperMarket\Controllers;

use SuperMarket\Models\Category;

class CategoryController{
    private Category $categoryModel;

    public function __construct(Category $model){
        $this->categoryModel = $model;
    }

    //POST /categories
    public function store(array $data){

        $returned_id = $this->categoryModel->create($data);

        if($returned_id){
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'category created successfully with id: ' . $returned_id], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'category failed to be created'], JSON_PRETTY_PRINT);
        }
        
    }

    //GET /categories
    public function index(){
        $categories = $this->categoryModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($categories, JSON_PRETTY_PRINT);
    }

    //PUT /categories/{:id}

    //DELETE /categories/{:id}
}

?>