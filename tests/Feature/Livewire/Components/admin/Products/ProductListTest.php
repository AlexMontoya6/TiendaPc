<?php

use App\Livewire\Components\Admin\Products\ProductList;
use Livewire\Livewire;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);


beforeEach(function () {
    $this->product1 = $this->newProduct();
    $this->product2 = $this->newProduct();
});

it('se renderiza correctamente', function () {
    Livewire::test(ProductList::class)
        ->assertStatus(200);
});

it('muestra productos paginados', function () {
    Livewire::test(ProductList::class)
        ->assertSee($this->product1->name)
        ->assertSee($this->product2->name);
});

it('filtra productos cuando se busca por nombre', function () {
    $productoEspecial = $this->newProduct();
    $productoEspecial->update(['name' => 'Producto Especial']);

    Livewire::test(ProductList::class)
        ->call('updateSearch', 'Producto Especial')
        ->assertSee('Producto Especial')
        ->assertDontSee($this->product1->name)
        ->assertDontSee($this->product2->name);
});

it('muestra el botón de eliminar pero no maneja el evento de borrado', function () {
    Livewire::test(ProductList::class)
        ->assertSee('Eliminar')
        ->assertSee($this->product1->name);
});
