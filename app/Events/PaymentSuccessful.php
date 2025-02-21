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
    public $purchased_products;

    /**
     * Crear una nueva instancia del evento.
     */
    public function __construct($payment_id, $user_email, $purchased_products)
    {
        $this->payment_id = $payment_id;
        $this->user_email = $user_email;
        $this->purchased_products = $purchased_products;
    }
}
