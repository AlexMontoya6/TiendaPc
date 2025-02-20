<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf_path;

    public function __construct($pdf_path)
    {
        $fullPath = storage_path("app/public/tickets/" . basename($pdf_path));

        if (!file_exists($fullPath)) {
            Log::error("El archivo PDF no existe: " . $fullPath);
            $this->pdf_path = null;
        } else {
            $this->pdf_path = $fullPath;
        }
    }

    public function build()
    {
        $email = $this->subject('Confirmación de Compra')
                      ->markdown('emails.purchase_confirmation');

        // Solo adjuntar si el PDF existe
        if ($this->pdf_path) {
            $email->attach($this->pdf_path);
        } else {
            Log::error("Intento de enviar email sin archivo adjunto.");
        }

        return $email;
    }
}
