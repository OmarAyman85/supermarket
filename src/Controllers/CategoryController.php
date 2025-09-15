<?php
namespace SuperMarket\Controllers;

use SuperMarket\Models\Category;
use SuperMarket\Helpers\Validator;

class CategoryController{
    private Category $categoryModel;
    private Validator $validator;

    public function __construct(){
        $this->categoryModel = new Category();
        $this->validator = new Validator();
    }

    //POST /categories
    public function store(array $data){

        $errors = $this->validator->getCategoryValidationError($data);

        if(!empty($errors)){
            http_response_code(422);
            echo json_encode(["errors" => $errors], JSON_PRETTY_PRINT);
            return;
        }

        $returned_id = $this->categoryModel->create($data);

        if($returned_id){
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'category created successfully with id: ' . $returned_id], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'category failed to be created ...'], JSON_PRETTY_PRINT);
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