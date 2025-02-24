<?php

use App\Models\Payment;
use Tests\Traits\CreatesUsers;
use Tests\Traits\CreatesProducts;

uses(CreatesUsers::class, CreatesProducts::class);

it('permite crear un pago correctamente', function () {
    $user = self::loginAsUser();
    $product = $this->newProduct();

    $payment = new Payment();
    $payment->payment_id = 'PAY-123456';
    $payment->user_id = $user->id;
    $payment->product_id = $product->id;
    $payment->product_name = $product->name;
    $payment->quantity = 2;
    $payment->amount = '19999'; // Se guarda en centavos
    $payment->currency = 'EUR';
    $payment->payer_name = $user->name;
    $payment->payer_email = $user->email;
    $payment->payment_status = 'completed';
    $payment->payment_method = 'paypal';
    $payment->save();

    expect(Payment::find($payment->id))->not->toBeNull()
        ->and($payment->user_id)->toBe($user->id)
        ->and($payment->product_id)->toBe($product->id)
        ->and($payment->amount)->toBe('19999')
        ->and($payment->payment_status)->toBe('completed');
});

it('un pago pertenece a un producto', function () {
    $user = self::loginAsUser();
    $product = $this->newProduct();

    $payment = new Payment();
    $payment->payment_id = 'PAY-PRODUCT-456';
    $payment->user_id = $user->id;
    $payment->product_id = $product->id;
    $payment->product_name = $product->name;
    $payment->quantity = 3;
    $payment->amount = '14999'; // 149.99€
    $payment->currency = 'EUR';
    $payment->payer_name = $user->name;
    $payment->payer_email = $user->email;
    $payment->payment_status = 'completed';
    $payment->payment_method = 'paypal';
    $payment->save();

    expect($payment->product)->not->toBeNull()
        ->and($payment->product)->toBeInstanceOf(\App\Models\Product::class);
});

