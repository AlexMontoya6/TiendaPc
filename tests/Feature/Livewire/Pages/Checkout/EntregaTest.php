<?php

use Livewire\Livewire;
use App\Livewire\Pages\Checkout\Entrega;
use Illuminate\Support\Facades\Session;

it('carga el método de entrega por defecto', function () {
    Livewire::test(Entrega::class)
        ->assertSet('delivery_method', 'standard');
});

it('permite cambiar el método de entrega', function () {
    Livewire::test(Entrega::class)
        ->call('setDeliveryMethod', 'express')
        ->assertSet('delivery_method', 'express');
});

it('guarda el método de entrega en la sesión', function () {
    Session::flush(); // Limpiar la sesión antes de ejecutar el test

    Livewire::test(Entrega::class)
        ->call('setDeliveryMethod', 'pickup')
        ->call('save');

    expect(Session::get('delivery_method'))->toBe('pickup');
});

it('redirige correctamente al resumen de pago', function () {
    Livewire::test(Entrega::class)
        ->call('save')
        ->assertRedirect(route('cart.checkout.resumen_pago'));
});
