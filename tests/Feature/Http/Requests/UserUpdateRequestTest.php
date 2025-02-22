<?php

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Mockery;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Customer']);
});


function getMockedRequest(User $user): UserUpdateRequest
{
    $request = new UserUpdateRequest();
    $request->setRouteResolver(function () use ($user) {
        $mockRoute = Mockery::mock(\Illuminate\Routing\Route::class);
        $mockRoute->shouldReceive('parameter')
            ->with('user', Mockery::any()) // Permite un valor por defecto
            ->andReturn($user);
        return $mockRoute;
    });

    return $request;
}

it('valida correctamente la actualización de un usuario', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Actualizado',
        'email' => $user->email,
        'password' => null,
        'password_confirmation' => null,
        'role' => 'Customer',
    ];

    $request = getMockedRequest($user);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeFalse();
});

it('falla si falta el campo email', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Test',
        'password' => null,
        'password_confirmation' => null,
        'role' => 'Customer',
    ];

    $request = getMockedRequest($user);
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

it('falla si el email ya existe en otro usuario', function () {
    $user1 = User::factory()->create(['email' => 'usuario1@example.com']);
    $user2 = User::factory()->create(['email' => 'usuario2@example.com']);

    $data = [
        'name' => 'Usuario Test',
        'email' => $user1->email,
        'password' => null,
        'password_confirmation' => null,
        'role' => 'Customer',
    ];

    $request = getMockedRequest($user2);
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

it('falla si la contraseña es demasiado corta', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Test',
        'email' => $user->email,
        'password' => '1234',
        'password_confirmation' => '1234',
        'role' => 'Customer',
    ];

    $request = getMockedRequest($user);
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});

it('falla si la confirmación de contraseña no coincide', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Test',
        'email' => $user->email,
        'password' => 'password123',
        'password_confirmation' => 'diferente123',
        'role' => 'Customer',
    ];

    $request = getMockedRequest($user);
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});

it('falla si el rol no existe en la base de datos', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Usuario Test',
        'email' => $user->email,
        'password' => null,
        'password_confirmation' => null,
        'role' => 'RolInvalido',
    ];

    $request = getMockedRequest($user);
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('role'))->toBeTrue();
});
