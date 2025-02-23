<?php

use Tests\Traits\CreatesProducts;
use function Pest\Laravel\getJson;

uses( CreatesProducts::class);

it('devuelve todos los productos', function () {
    $this->newProduct(); // 🔥 Creamos un producto con el Trait
    $this->newProduct(); // Otro producto

    $response = getJson('/api/public/products');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'price', 'description', 'available', 'category', 'created_at']
            ]
        ])
        ->assertJsonCount(2, 'data'); // 🔥 Se crean 2 productos
});


it('filtra productos por búsqueda', function () {
    $product = $this->newProduct();
    $product->update(['name' => 'MacBook Pro']);

    $this->newProduct()->update(['name' => 'iPhone 15']);

    $response = getJson('/api/public/products?search=MacBook');

    $response->assertOk()
        ->assertJsonCount(1, 'data'); // Solo debe devolver MacBook Pro
});

it('aplica paginación correctamente', function () {
    for ($i = 0; $i < 15; $i++) {
        $this->newProduct();
    }

    $response = getJson('/api/public/products?page=1');

    $response->assertOk()
        ->assertJsonStructure([
            'data',
            'links',
            'meta'
        ]);
});
