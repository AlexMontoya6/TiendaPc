<?php

use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;

it('valida correctamente un usuario válido', function () {

    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Usuario Test',
        'email' => 'usuario@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => $role->name,
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeFalse();
});

it('falla si falta el campo email', function () {
    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Usuario Test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => $role->name,
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

it('falla si el email ya existe', function () {
    $role = Role::firstOrCreate(['name' => 'Customer']);

    User::factory()->create(['email' => 'usuario@example.com']);

    $data = [
        'name' => 'Otro Usuario',
        'email' => 'usuario@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => $role->name,
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

it('falla si la contraseña es demasiado corta', function () {
    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Usuario Test',
        'email' => 'usuario@example.com',
        'password' => '1234',
        'password_confirmation' => '1234',
        'role' => $role->name,
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});

it('falla si la confirmación de contraseña no coincide', function () {
    $role = Role::firstOrCreate(['name' => 'Customer']);

    $data = [
        'name' => 'Usuario Test',
        'email' => 'usuario@example.com',
        'password' => 'password123',
        'password_confirmation' => 'diferente123',
        'role' => $role->name,
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});

it('falla si el rol no existe en la base de datos', function () {
    $data = [
        'name' => 'Usuario Test',
        'email' => 'usuario@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'RolInvalido',
    ];

    $validator = Validator::make($data, (new UserStoreRequest())->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('role'))->toBeTrue();
});

