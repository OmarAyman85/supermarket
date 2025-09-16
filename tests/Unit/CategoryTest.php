<?php

use SuperMarket\Models\Category;
use SuperMarket\Database\Database;

//RESTART THE ENVIRONMENT "DATABASE"
beforeAll(function(){
        $database = new Database();
        $conn = $database->getCOnnection();
        $conn->exec("DELETE FROM categories");
    });

// CREATING AND FETCHING A CATEGORY
it('can create a category in the database and find it by the ID', function(){
    $categoryModel = new Category();

    $category_id = $categoryModel->create([
        'name' => 'TEST'
    ]);

    $category = $categoryModel->find($category_id);
    
    expect($category)->toBeArray();

    expect($category['id'])->toBeInt()->toBe($category_id);
    
    expect($category['name'])->toBeString()->toBe("TEST");
});

//FETCHING ALL CATEGORIES
it('can fetch all categories from the database', function () {
    $categoryModel = new Category();

    $category1Id = $categoryModel->create([
        'name' => 'Category 1',
    ]);

    $category2Id = $categoryModel->create([
        'name' => 'Category 2',
    ]);

    $categories = $categoryModel->getAll();

    expect($categories)->toBeArray();
    expect(count($categories))->toBeGreaterThanOrEqual(2);

    $names = array_column($categories, 'name');
    expect($names)->toContain('Category 1');
    expect($names)->toContain('Category 2');
});

// UPDATING A CATEGORY
it('can update a category', function(){
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Category To Be Updated',
    ]);

    $category = $categoryModel->find($categoryId);
    
    $updatedRows = $categoryModel->update($category, ['name' => 'Category Updated']);
    
    expect($updatedRows)->toBe(1);

    $updatedCategory = $categoryModel->find($categoryId);
    
    expect($updatedCategory['id'])->toBeInt()->toBe($categoryId);
    expect($updatedCategory['name'])->toBeString()->toBe("Category Updated");
});

//DELETING A CATEGORY
it('can delete a category', function(){
    $categoryModel = new Category();

    $categoryId = $categoryModel->create([
        'name' => 'Category To Be Deleted',
    ]);

    $deletedRows = $categoryModel->destroy($categoryId);

    expect($deletedRows)->toBe(1);

    $deletedCategory = $categoryModel->find($categoryId);
    expect($deletedCategory)->toBeFalse(); 
})

?>