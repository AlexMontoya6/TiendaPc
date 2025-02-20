<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Jobs\SendPurchaseEmailJob;
use App\Jobs\RedirectToHomeJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleSuccessfulPayment implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Manejar el evento de pago exitoso.
     */
    public function handle(PaymentSuccessful $event)
    {
        // Encolar el job para enviar el email con el PDF adjunto
        SendPurchaseEmailJob::dispatch($event->user_email, $event->pdf_path);


    }
}
