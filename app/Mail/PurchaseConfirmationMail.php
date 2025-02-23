<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    public function build()
    {
        return $this->subject('Confirmación de Compra')
            ->markdown('emails.purchase_confirmation');

    }
}
