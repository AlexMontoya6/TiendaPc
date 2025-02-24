<?php

use function Pest\Laravel\postJson;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);


it('impide el registro con datos inválidos', function () {
    $response = postJson('/api/register', [
        'name' => '',
        'email' => 'correo-no-valido',
        'password' => '123',
        'password_confirmation' => '456', // Contraseña mal confirmada
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});

it('permite a un usuario iniciar sesión con credenciales correctas', function () {
    $user = $this->loginAsUser();

    $user->update(['password' => bcrypt('password123')]);

    $response = postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['token']);
});


it('impide iniciar sesión con credenciales incorrectas', function () {
    $user = $this->loginAsUser();

    $response = postJson('/api/login', [
        'email' => $user->email,
        'password' => 'contraseñaIncorrecta',
    ]);

    $response->assertUnauthorized()
        ->assertJsonPath('message', fn($msg) => str_contains($msg, 'Credenciales'));
});
