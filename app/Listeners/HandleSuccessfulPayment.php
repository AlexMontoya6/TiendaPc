<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Jobs\ClearCartJob;
use App\Jobs\SendPurchaseEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleSuccessfulPayment implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Manejar el evento de pago exitoso.
     */
    public function handle(PaymentSuccessful $event)
    {

        try {
            // Primero, limpiar el carrito
            dispatch(new ClearCartJob())->onQueue('default');
            Log::info("ClearCartJob encolado correctamente.");
        } catch (\Exception $e) {
            Log::error("Error al encolar ClearCartJob: " . $e->getMessage());
        }


        try {
            Log::info("HandleSuccessfulPayment ejecutado con", [
                'payment_id' => $event->payment_id,
                'user_email' => $event->user_email
            ]);

            dispatch(new SendPurchaseEmailJob($event->user_email))->onQueue('default');


            Log::info("Jobs encolados correctamente.");
        } catch (\Exception $e) {
            Log::error("Error en HandleSuccessfulPayment: " . $e->getMessage());
        }
    }
}
