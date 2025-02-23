<?php

use App\Models\User;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = self::loginAsUser();

    $response = $this->get(route('panel.mi-perfil'));

    $this->assertAuthenticatedAs($user);
    $response->assertStatus(200);
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
