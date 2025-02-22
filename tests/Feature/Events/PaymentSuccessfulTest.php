<?php

use App\Events\PaymentSuccessful;
use Illuminate\Support\Facades\Event;

it('se dispara correctamente el evento PaymentSuccessful', function () {

    Event::fake();

    $paymentId = 12345;
    $userEmail = 'test@example.com';

    event(new PaymentSuccessful($paymentId, $userEmail));

    Event::assertDispatched(PaymentSuccessful::class, function ($event) use ($paymentId, $userEmail) {
        return $event->payment_id === $paymentId && $event->user_email === $userEmail;
    });
});
