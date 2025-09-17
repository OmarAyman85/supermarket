<?php

use SuperMarket\Models\Product;
use SuperMarket\Models\Category;
use SuperMarket\Database\Database;

//RESTART THE ENVIRONMENT "DATABASE"
beforeAll(function(){
    $database = new Database();
    $conn = $database->getConnection();
    $conn->exec("DELETE FROM products");
    $conn->exec("DELETE FROM categories");
});


// CREATING AND FETCHING A PRODUCT
it('can create a product in the database and find it by the ID', function(){
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Test Category'
    ]);

    $productModel = new Product();

    $productId = $productModel->create([
        'name' => 'TEST',
        'category_id' => $categoryId,
        'price' => '22.22'
    ]);

    $product = $productModel->find($productId);
    
    expect($product)->toBeArray();

    expect($product['id'])->toBeInt()->toBe($productId);
    
    expect($product['name'])->toBeString()->toBe("TEST");
    expect($product['price'])->toBeString()->toBe("22.22");
});

//FETCHING ALL PRODUCTS
it('can fetch all products from the database', function () {
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Test Category'
    ]);

    $productModel = new Product();

    $product1Id = $productModel->create([
        'name' => 'Product 1',
        'category_id' => $categoryId,
        'price' => '22.23'
    ]);

    $product2Id = $productModel->create([
        'name' => 'Product 2',
        'category_id' => $categoryId,
        'price' => '22.24'
    ]);

    $products = $productModel->getAll();

    expect($products)->toBeArray();
    expect(count($products))->toBeGreaterThanOrEqual(2);

    $names = array_column($products, 'product_name');
    expect($names)->toContain('Product 1');
    expect($names)->toContain('Product 2');
});

// UPDATING A PRODUCT
it('can update a product', function(){
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Test Category'
    ]);

    $productModel = new Product();

    $productId = $productModel->create([
        'name' => 'Category To Be Updated',
        'category_id' => $categoryId,
        'price' => '22.25'
    ]);

    $product = $productModel->find($productId);
    
    $updatedRows = $productModel->update($product, ['name' => 'Product Updated', 'price' => '22.55']);
    
    expect($updatedRows)->toBe(1);

    $updatedProduct = $productModel->find($productId);
    
    expect($updatedProduct['id'])->toBeInt()->toBe($productId);
    expect($updatedProduct['name'])->toBeString()->toBe("Product Updated");
    expect($updatedProduct['price'])->toBeString()->toBe('22.55');
}); 

//DELETING A PRODUCT
it('can delete a product', function(){
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Test Category'
    ]);

    $productModel = new Product();

    $productId = $productModel->create([
        'name' => 'Product To Be Updated',
        'category_id' => $categoryId,
        'price' => '22.26'
    ]);

    $deletedRows = $productModel->destroy($productId);

    expect($deletedRows)->toBe(1);

    $deletedProduct = $productModel->find($productId);
    expect($deletedProduct)->toBeFalse(); 
})

?>