<?php

use App\Http\Requests\ProductStoreRequest;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Validator;

it('valida correctamente un producto válido', function () {

    $productType = ProductType::factory()->create();
    $category = Category::factory()->create();
    $subcategory = Subcategory::factory()->create();

    $data = [
        'name' => 'Producto Test',
        'description' => 'Descripción del producto.',
        'price' => 200,
        'product_type_id' => $productType->id,
        'category_id' => $category->id,
        'subcategory_id' => $subcategory->id,
    ];

    $validator = Validator::make($data, (new ProductStoreRequest)->rules());

    expect($validator->fails())->toBeFalse();
});

it('falla si falta el campo name', function () {
    $data = [
        'slug' => 'producto-test',
        'description' => 'Descripción del producto.',
        'price' => 49.99,
        'stock' => 15,
        'product_type_id' => 1,
    ];

    $validator = Validator::make($data, (new ProductStoreRequest)->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('name'))->toBeTrue();
});
