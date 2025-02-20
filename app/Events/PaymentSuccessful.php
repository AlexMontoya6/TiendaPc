<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessful
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payment_id;
    public $user_email;
    public $pdf_path;

    /**
     * Crear una nueva instancia del evento.
     */
    public function __construct($payment_id, $user_email, $pdf_path)
    {
        $this->payment_id = $payment_id;
        $this->user_email = $user_email;
        $this->pdf_path = $pdf_path;
    }
}
