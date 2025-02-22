<?php

use App\Livewire\Pages\Admin\Products;
use App\Models\Product;
use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesUsers;
use Livewire\Livewire;

uses(CreatesProducts::class, CreatesUsers::class);

//PARA EL INDEX

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

//PARA EL CREATE
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



