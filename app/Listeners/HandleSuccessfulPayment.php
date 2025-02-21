<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Jobs\SendPurchaseEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdateStockJob;

class HandleSuccessfulPayment implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Manejar el evento de pago exitoso.
     */
    public function handle(PaymentSuccessful $event)
    {
        try {
            Log::info("HandleSuccessfulPayment ejecutado con", [
                'payment_id' => $event->payment_id,
                'user_email' => $event->user_email
            ]);

            // Actualizar el stock de los productos comprados
            dispatch(new UpdateStockJob($event->purchased_products));

            // Encolar el job para enviar el email
            dispatch(new \App\Jobs\SendPurchaseEmailJob($event->user_email));

            Log::info("Jobs encolados correctamente.");
        } catch (\Exception $e) {
            Log::error("Error en HandleSuccessfulPayment: " . $e->getMessage());
        }
    }
}
