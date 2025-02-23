<?php

use Laravel\Sanctum\Sanctum;
use Tests\Traits\CreatesUsers; // 🔥 Importamos el trait

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(CreatesUsers::class); // 🔥 Usamos el trait en el test

beforeEach(function () {
    // 🔥 Creamos los usuarios con el trait
    $this->superAdmin = $this->actingAsSuperAdmin();
    $this->customer = $this->loginAsUser();
});

it('permite a un SuperAdmin listar usuarios', function () {
    Sanctum::actingAs($this->superAdmin, ['*']);

    $response = getJson('/api/admin/users');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'email'],
            ],
        ]);
});

it('impide a un usuario normal listar usuarios', function () {
    Sanctum::actingAs($this->customer);

    $response = getJson('/api/admin/users');

    $response->assertForbidden();
});

it('permite a un SuperAdmin ver un usuario específico', function () {
    Sanctum::actingAs($this->superAdmin);

    $response = getJson('/api/admin/users/'.$this->customer->id);

    $response->assertOk()
        ->assertJsonPath('data.id', $this->customer->id);
});

it('impide a un usuario normal ver otro usuario', function () {
    Sanctum::actingAs($this->customer);

    $response = getJson('/api/admin/users/'.$this->superAdmin->id);

    $response->assertForbidden();
});

it('permite a un SuperAdmin crear un usuario', function () {
    Sanctum::actingAs($this->superAdmin);

    $response = postJson('/api/admin/users', [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@user.com',
        'password' => 'password123',
        'role' => 'Customer',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.email', 'nuevo@user.com');
});

it('impide a un usuario normal crear un usuario', function () {
    Sanctum::actingAs($this->customer);

    $response = postJson('/api/admin/users', [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@user.com',
        'password' => 'password123',
        'role' => 'Admin',
    ]);

    $response->assertForbidden();
});

it('permite a un SuperAdmin actualizar un usuario', function () {
    Sanctum::actingAs($this->superAdmin);

    $response = putJson('/api/admin/users/'.$this->customer->id, [
        'name' => 'Usuario Modificado',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.name', 'Usuario Modificado');
});

it('impide a un usuario normal actualizar otro usuario', function () {
    Sanctum::actingAs($this->customer);

    $response = putJson('/api/admin/users/'.$this->superAdmin->id, [
        'name' => 'Intento de Cambio',
    ]);

    $response->assertForbidden();
});

it('permite a un SuperAdmin eliminar un usuario', function () {
    Sanctum::actingAs($this->superAdmin);

    $response = deleteJson('/api/admin/users/'.$this->customer->id);

    $response->assertOk();
});

it('impide a un usuario normal eliminar otro usuario', function () {
    Sanctum::actingAs($this->customer);

    $response = deleteJson('/api/admin/users/'.$this->superAdmin->id);

    $response->assertForbidden();
});
