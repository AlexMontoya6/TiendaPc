<?php

use App\Livewire\Pages\Cart;
use Gloudemans\Shoppingcart\Facades\Cart as Shoppingcart;
use Livewire\Livewire;
use Tests\Traits\CreatesProducts;

uses(CreatesProducts::class);

beforeEach(function () {
    Shoppingcart::destroy();
});

it('muestra correctamente el carrito con productos', function () {
    $product = $this->newProduct();

    $product->update(['price' => 99.99]);

    Shoppingcart::add($product->id, $product->name, 2, $product->price);

    Livewire::test(Cart::class)
        ->assertSee($product->name)
        ->assertSee('99.99')
        ->assertSee('2');
});


it('agrega un producto al carrito correctamente', function () {
    $product = $this->newProduct();

    $product->update(['price' => 49.99]);

    Livewire::test(Cart::class)
        ->call('addProductToCart', ['productId' => $product->id])
        ->assertSee($product->name)
        ->assertSee('49.99');

    expect(Shoppingcart::count())->toBe(1);
});


it('actualiza la cantidad de un producto en el carrito', function () {
    $product = $this->newProduct();
    $item = Shoppingcart::add($product->id, $product->name, 1, $product->price);

    Livewire::test(Cart::class)
        ->call('updateQuantity', $item->rowId, 3)
        ->assertSee('3');

    expect(Shoppingcart::get($item->rowId)->qty)->toBe(3);
});

it('elimina un producto del carrito correctamente', function () {
    $product = $this->newProduct();
    $item = Shoppingcart::add($product->id, $product->name, 1, $product->price);

    Livewire::test(Cart::class)
        ->call('removeFromCart', $item->rowId)
        ->assertDontSee($product->name);

    expect(Shoppingcart::count())->toBe(0);
});

it('emite evento al agregar un producto al carrito', function () {
    $product = $this->newProduct();

    Livewire::test(Cart::class)
        ->call('addProductToCart', ['productId' => $product->id])
        ->assertDispatched('cartUpdated');
});
