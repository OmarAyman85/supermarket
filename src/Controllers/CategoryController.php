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
    
    //GET /categories/{:id}
    public function find(int $id){
        $category = $this->categoryModel->find($id);
        if(! $category){
            http_response_code(404);
            echo json_encode(["message" => "Category not found"], JSON_PRETTY_PRINT);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($category, JSON_PRETTY_PRINT);
    }

    //PUT /categories/{:id}
    public function update(int $id, array $data){

        $errors = $this->validator->getCategoryValidationError($data);

        if(!empty($errors)){
            http_response_code(422);
            echo json_encode(["errors" => $errors], JSON_PRETTY_PRINT);
            return;
        }

        $category = $this->categoryModel->find($id);
        if(! $category){
            http_response_code(404);
            echo json_encode(["message" => "Product not found"], JSON_PRETTY_PRINT);
            return;
        }
        
        $rows = $this->categoryModel->update($category ,$data);

        echo json_encode(['Category with the id: ' . $id . " is updated successfully",
                            "rows affected" => $rows], 
                            JSON_PRETTY_PRINT);
    }
    
    //DELETE /categories/{:id}
    public function destroy(int $id){

        $rows = $this->categoryModel->destroy($id);
        
        echo json_encode(['Category with the id: ' . $id . " is deleted successfully",
                        "rows affected" => $rows], 
                        JSON_PRETTY_PRINT);
    }

}

?>