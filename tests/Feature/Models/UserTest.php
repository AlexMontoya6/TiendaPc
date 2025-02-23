<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

it('puede crear un usuario correctamente', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->not->toBeNull()
        ->and($user->email)->not->toBeNull();
});

it('asigna automáticamente el rol Customer al crear un usuario', function () {
    $user = User::factory()->create();

    expect($user->hasRole('Customer'))->toBeTrue();
});

it('permite asignar y cambiar un rol correctamente', function () {
    $user = User::factory()->create();
    $adminRole = Role::firstOrCreate(['name' => 'Admin']);

    $user->assignSingleRole('Admin');

    expect($user->hasRole('Admin'))->toBeTrue();
});

it('oculta datos sensibles en la serialización', function () {
    $user = User::factory()->create();
    $array = $user->toArray();

    expect($array)
        ->not->toHaveKey('password')
        ->not->toHaveKey('remember_token')
        ->not->toHaveKey('two_factor_recovery_codes')
        ->not->toHaveKey('two_factor_secret');
});

it('genera correctamente el profile_photo_url', function () {
    $user = User::factory()->create();

    expect($user->profile_photo_url)->not->toBeNull();
});
