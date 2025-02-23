<?php

use App\Livewire\Components\Admin\Products\ProductForm;
use App\Models\ProductType;
use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Livewire;

beforeEach(function () {
    $this->productType = ProductType::factory()->create();
    $this->category = Category::factory()->create(['product_type_id' => $this->productType->id]);
    $this->subcategory = Subcategory::factory()->create(['category_id' => $this->category->id]);
});

it('se renderiza correctamente', function () {
    Livewire::test(ProductForm::class)
        ->assertStatus(200);
});

it('carga los tipos de producto al montarse', function () {
    Livewire::test(ProductForm::class)
        ->assertCount('productTypes', 1);
});

it('carga las categorías cuando se selecciona un tipo de producto', function () {
    Livewire::test(ProductForm::class)
        ->set('selectedProductType', $this->productType->id)
        ->assertCount('categories', 1)
        ->assertSet('subcategories', []);
});

it('carga las subcategorías cuando se selecciona una categoría', function () {
    Livewire::test(ProductForm::class)
        ->set('selectedProductType', $this->productType->id)
        ->set('selectedCategory', $this->category->id)
        ->assertCount('subcategories', 1);
});

it('resetea la selección de categoría y subcategoría cuando se cambia el tipo de producto', function () {
    Livewire::test(ProductForm::class)
        ->set('selectedProductType', $this->productType->id)
        ->set('selectedCategory', $this->category->id)
        ->set('selectedSubcategory', $this->subcategory->id)
        ->set('selectedProductType', null)
        ->assertSet('categories', [])
        ->assertSet('subcategories', [])
        ->assertSet('selectedCategory', null)
        ->assertSet('selectedSubcategory', null);
});

