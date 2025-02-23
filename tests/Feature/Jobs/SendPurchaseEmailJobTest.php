<?php

use App\Jobs\SendPurchaseEmailJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmationMail;

it('envía un correo de confirmación de compra', function () {
    Mail::fake();

    dispatch(new SendPurchaseEmailJob('test@example.com'));

    Mail::assertSent(PurchaseConfirmationMail::class);
});
