<?php

use App\Livewire\Pages\Admin\Products;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesUsers;

uses(CreatesProducts::class, CreatesUsers::class);

// PARA EL INDEX

it('muestra un producto correctamente', function () {

    $this->newProduct();

    Livewire::test(Products::class)
        ->assertOk()
        ->assertSee(Product::first()->name);
});

it('permite filtrar productos por nombre', function () {

    // Crear productos con nombres específicos usando `newProduct()`
    $laptop = $this->newProduct();
    $laptop->update(['name' => 'Laptop HP']);

    $mouse = $this->newProduct();
    $mouse->update(['name' => 'Mouse Logitech']);

    // Buscar "Laptop"
    Livewire::test(Products::class)
        ->set('search', 'Laptop')
        ->assertSee('Laptop HP')
        ->assertDontSee('Mouse Logitech');
});

// PARA EL CREATE
it('permite a un admin acceder a la página de creación de productos', function () {
    $this->actingAsSuperAdmin();

    $this->get(route('admin.products.create'))
        ->assertOk()
        ->assertSee('Crear Producto');
});

it('impide a un usuario no autorizado acceder a la creación de productos', function () {
    self::loginAsUser();

    $this->get(route('admin.products.create'))
        ->assertForbidden();
});

// PARA EL STORE
it('permite a un admin crear un producto con imágenes', function () {
    $this->actingAsSuperAdmin();

    Storage::fake('public');

    $productType = ProductType::factory()->create();
    $category = Category::factory()->create();
    $subcategory = Subcategory::factory()->create();

    $productData = [
        'name' => 'Producto Test',
        'description' => 'Descripción del producto.',
        'price' => 150,
        'product_type_id' => $productType->id,
        'category_id' => $category->id,
        'subcategory_id' => $subcategory->id,
    ];

    $images = [
        UploadedFile::fake()->image('imagen1.jpg'),
        UploadedFile::fake()->image('imagen2.jpg'),
    ];

    $response = $this->post(route('admin.products.store'), array_merge($productData, ['images' => $images]));

    $this->assertDatabaseHas('products', ['name' => 'Producto Test']);

    foreach ($images as $image) {
        Storage::disk('public')->assertExists('products/'.$image->hashName());
        $this->assertDatabaseHas('images', ['path' => 'products/'.$image->hashName()]);
    }

    $response->assertRedirect(route('admin.products.index'));
    $response->assertSessionHas('success', 'Producto creado correctamente.');
});
