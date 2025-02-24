<?php

use App\Livewire\Pages\Checkout\Direcciones;
use App\Models\User;
use App\Models\Address;
use Livewire\Livewire;
use Tests\Traits\CreatesUsers;

uses(CreatesUsers::class);

it('muestra las direcciones del usuario correctamente', function () {
    $user = self::loginAsUser();

    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Casa',
        'street' => 'Calle Falsa 123',
        'city' => 'Madrid',
        'postal_code' => '28001',
        'country' => 'España',
        'is_default' => true, // Aseguramos que sea predeterminada
    ]);

    Livewire::test(Direcciones::class)
        ->assertSee('Selecciona tu dirección de envío') // Más seguro que "Dirección"
        ->assertSee($address->street);
});

it('permite seleccionar una dirección existente', function () {
    $user = self::loginAsUser();

    $address = Address::create([
        'user_id' => $user->id,
        'name' => 'Trabajo',
        'street' => 'Gran Vía 45',
        'city' => 'Madrid',
        'postal_code' => '28013',
        'country' => 'España',
        'is_default' => false,
    ]);

    Livewire::test(Direcciones::class)
        ->call('setDefaultAddress', $address->id) // 🔥 Se usa `setDefaultAddress` en vez de `selectAddress`
        ->assertSet('addresses.0.is_default', true); // 🔥 Verificamos que se actualizó correctamente
});
