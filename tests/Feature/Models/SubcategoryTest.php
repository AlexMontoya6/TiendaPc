<?php

use App\Models\Subcategory;
use App\Models\Category;
use App\Models\ProductType;

use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

beforeEach(function () {
    $this->productType = ProductType::factory()->create();

    $this->category = Category::factory()->create([
        'product_type_id' => $this->productType->id,
    ]);

    $this->subcategory = Subcategory::factory()->create([
        'category_id' => $this->category->id,
    ]);
});


it('puede crear una subcategoría', function () {
    $subcategory = Subcategory::factory()->create([
        'category_id' => $this->category->id,
    ]);

    expect($subcategory)->toBeInstanceOf(Subcategory::class)
        ->and($subcategory->category_id)->toBe($this->category->id);
});


it('puede pertenecer a una categoría', function () {
    $subcategory = Subcategory::factory()->create([
        'category_id' => $this->category->id,
    ]);

    expect($subcategory->category)->toBeInstanceOf(Category::class)
        ->and($subcategory->category->id)->toBe($this->category->id);
});


it('puede tener productos asociados', function () {
    $product = $this->newProduct();
    $product->subcategory()->associate($this->subcategory);
    $product->save();

    $this->subcategory->refresh();

    expect($this->subcategory->products)->toHaveCount(1)
        ->and($this->subcategory->products->first()->id)->toBe($product->id);
});
