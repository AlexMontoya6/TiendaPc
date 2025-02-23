<?php

use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesUsers;
use function Pest\Laravel\{getJson, deleteJson, postJson};


uses(CreatesProducts::class, CreatesUsers::class);



beforeEach(function () {
    $this->actingAsSuperAdmin();
});

it('devuelve todos los productos, incluyendo eliminados', function () {
    $producto1 = $this->newProduct();
    $productoEliminado = $this->newProduct();
    $productoEliminado->delete(); // 🔥 Simulamos SoftDelete

    $response = getJson('/api/admin/products');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'price', 'deleted_at']
            ]
        ])
        ->assertJsonFragment(['id' => $productoEliminado->id]);
});

it('elimina un producto con SoftDelete', function () {
    $producto = $this->newProduct();

    $response = deleteJson("/api/admin/products/{$producto->id}");

    $response->assertOk()
        ->assertJson(['message' => 'Producto eliminado correctamente.']);

    $this->assertSoftDeleted('products', ['id' => $producto->id]);
});

it('restaura un producto eliminado', function () {
    $producto = $this->newProduct();
    $producto->delete();

    $response = postJson("/api/admin/products/{$producto->id}/restore");

    $response->assertOk()
        ->assertJson(['message' => 'Producto restaurado correctamente.']);

    $this->assertDatabaseHas('products', ['id' => $producto->id, 'deleted_at' => null]);
});

it('elimina un producto permanentemente', function () {
    $producto = $this->newProduct();
    $producto->delete();

    $response = deleteJson("/api/admin/products/{$producto->id}/force-delete");

    $response->assertOk()
        ->assertJson(['message' => 'Producto eliminado permanentemente.']);

    $this->assertDatabaseMissing('products', ['id' => $producto->id]);
});
