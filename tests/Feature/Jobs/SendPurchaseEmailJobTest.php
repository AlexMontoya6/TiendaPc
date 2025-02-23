<?php

use App\Jobs\SendPurchaseEmailJob;
use App\Mail\PurchaseConfirmationMail;
use Illuminate\Support\Facades\Mail;

it('envía un correo de confirmación de compra', function () {
    Mail::fake();

    dispatch(new SendPurchaseEmailJob('test@example.com'));

    Mail::assertSent(PurchaseConfirmationMail::class);
});
