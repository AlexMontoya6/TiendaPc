<?php

use App\Models\Address;
use App\Models\User;
use Tests\Traits\CreatesUsers;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(CreatesUsers::class);

it('permite crear una dirección correctamente', function () {
    $user = self::loginAsUser();

    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true,
    ]);

    assertDatabaseHas('addresses', [
        'id' => $address->id,
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true,
    ]);
});

it('permite actualizar una dirección', function () {
    $user = self::loginAsUser();
    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true,
    ]);

    $address->update(['street' => 'Nueva Calle 456']);

    assertDatabaseHas('addresses', ['id' => $address->id, 'street' => 'Nueva Calle 456']);
});

it('permite eliminar una dirección', function () {
    $user = self::loginAsUser();
    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true,
    ]);

    $address->delete();

    assertDatabaseMissing('addresses', ['id' => $address->id]);
});

it('una dirección pertenece a un usuario', function () {
    $user = self::loginAsUser();
    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true,
    ]);

    expect($address->user)->toBeInstanceOf(User::class);
    expect($address->user->id)->toBe($user->id);
});
