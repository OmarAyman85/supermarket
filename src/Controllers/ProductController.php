<?php
namespace SuperMarket\Controllers;

use SuperMarket\Models\Product;
use SuperMarket\Helpers\Validator;

class ProductController{
    private Product $productModel;
    private Validator $validator;

    public function __construct(){
        $this->productModel = new Product();
        $this->validator = new Validator();
    }

    //POST /products
    public function store(array $data){

        $errors = array_merge(
            $this->validator->getProductValidationError($data),
            $this->validator->categoryExistanceValidation($data)
        );

        if(!empty($errors)){
            http_response_code(422);
            echo json_encode(["errors" => $errors], JSON_PRETTY_PRINT);
            return;
        }

        $returned_id = $this->productModel->create($data);

        if($returned_id && $returned_id != 0){
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'product created successfully with id: ' . $returned_id], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'product failed to be created ...'], JSON_PRETTY_PRINT);
        } 
    }

    //GET /products
    public function index(){
        $categories = $this->productModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($categories, JSON_PRETTY_PRINT);
    }

    //GET /products/{:id}
    public function find(int $id){
        $product = $this->productModel->find($id);
        if(! $product){
            http_response_code(404);
            echo json_encode(["message" => "Product not found"], JSON_PRETTY_PRINT);
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($product, JSON_PRETTY_PRINT);
    }

    //PUT /products/{:id}
    public function update(int $id, array $data){

        $errors = array_merge(
            $this->validator->getProductValidationError($data),
            $this->validator->categoryExistanceValidation($data)
        );

        if(!empty($errors)){
            http_response_code(422);
            echo json_encode(["errors" => $errors], JSON_PRETTY_PRINT);
            return;
        }

        $product = $this->productModel->find($id);

        if(! $product){
            http_response_code(404);
            echo json_encode(["message" => "Product not found"], JSON_PRETTY_PRINT);
            return;
        }
        
        $rows = $this->productModel->update($product ,$data);

        echo json_encode(['Product with the id: ' . $id . " is updated successfully",
                            "rows affected" => $rows], 
                            JSON_PRETTY_PRINT);
    }

    //DELETE /categories/{:id}
    public function destroy(int $id){

        $rows = $this->productModel->destroy($id);
        
        echo json_encode(['Product with the id: ' . $id . " is deleted successfully",
                        "rows affected" => $rows], 
                        JSON_PRETTY_PRINT);
    }

}

?>