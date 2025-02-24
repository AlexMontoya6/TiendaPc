<?php

use App\Models\Payment;
use Tests\Traits\CreatesUsers;
use Tests\Traits\CreatesProducts;

use function Pest\Laravel\get;

uses(CreatesUsers::class, CreatesProducts::class);

it('permite descargar el ticket de una compra en PDF', function () {
    $user = self::loginAsUser();
    $product = $this->newProduct();

    $payment = new Payment();
    $payment->payment_id = 'PAY-PDF-123';
    $payment->user_id = $user->id;
    $payment->product_id = $product->id;
    $payment->product_name = $product->name;
    $payment->quantity = 2;
    $payment->amount = '24999';
    $payment->currency = 'EUR';
    $payment->payer_name = $user->name;
    $payment->payer_email = $user->email;
    $payment->payment_status = 'completed';
    $payment->payment_method = 'paypal';
    $payment->save();

    $response = get(route('payments.ticket', $payment->id));

    $response->assertOk()
        ->assertHeader('content-type', 'application/pdf');
});
