<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf_path;

    /**
     * Crear una nueva instancia del Mailable.
     */
    public function __construct($pdf_path)
    {
        $this->pdf_path = $pdf_path;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this->subject('Confirmación de compra - TiendaPc')
            ->markdown('emails.purchase_confirmation') // ✅ Usa la vista Markdown
            ->attach(storage_path('app/public/tickets/ticket_test.pdf')); // ✅ Ruta absoluta
    }
}
