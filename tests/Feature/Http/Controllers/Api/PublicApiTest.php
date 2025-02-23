<?php

use Illuminate\Support\Facades\RateLimiter;
use Tests\Traits\CreatesProducts;

use function Pest\Laravel\getJson;

uses(CreatesProducts::class);

it('devuelve productos destacados en JSON', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->newProduct();
    }

    $response = getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'price'],
            ],
        ])
        ->assertJsonCount(5, 'data');
});

it('devuelve solo productos activos y excluye los eliminados', function () {
    $producto1 = $this->newProduct();
    $producto2 = $this->newProduct();
    $productoEliminado = $this->newProduct();

    $productoEliminado->delete(); // 🔥 Simulamos un SoftDelete

    $response = getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'price'],
            ],
        ])
        ->assertJsonMissing(['id' => $productoEliminado->id]); // ✅ No debe aparecer el eliminado
});

it('respeta el límite de peticiones', function () {
    RateLimiter::clear('api'); // 🔥 Aseguramos que no haya límites previos

    // 🔹 Hacer 2 peticiones válidas
    getJson('/api/products')->assertOk();
    getJson('/api/products')->assertOk();

    // 🔥 La tercera debe fallar con `429 Too Many Requests`
    getJson('/api/products')->assertStatus(429);
});
