<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Jobs\SendPurchaseEmailJob;
use App\Jobs\GenerateInvoiceJob;
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
        Log::info("HandleSuccessfulPayment ejecutado con", [
            'payment_id' => $event->payment_id,
            'user_email' => $event->user_email,
            'pdf_path' => $event->pdf_path
        ]);

        // Generar la factura antes de enviarla
        $pdf_path = dispatch_sync(new \App\Jobs\GenerateInvoiceJob($event->payment_id));

        // Encolar el job para enviar el email
        dispatch(new \App\Jobs\SendPurchaseEmailJob($event->user_email, $pdf_path));

        Log::info("Jobs encolados correctamente.");
    } catch (\Exception $e) {
    Log::error("Error en HandleSuccessfulPayment: " . $e->getMessage());
    }
}


}
