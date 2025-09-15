<?php
namespace SuperMarket\Controllers;

use SuperMarket\Models\Category;

class CategoryController{
    private Category $categoryModel;

    public function __construct(Category $model){
        $this->categoryModel = $model;
    }

    //GET /categories
    public function index(){
        $categories = $this->categoryModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($categories, JSON_PRETTY_PRINT);
    }
}

?>