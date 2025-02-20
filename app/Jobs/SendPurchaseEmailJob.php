<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\PurchaseConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPurchaseEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_email;
    protected $pdf_path;

    /**
     * Crear una nueva instancia del job.
     */
    public function __construct($user_email, $pdf_path)
    {
        $this->user_email = $user_email;
        $this->pdf_path = $pdf_path;
    }

    /**
     * Ejecutar el job.
     */
    public function handle()
    {
        try {
            Log::info("Intentando enviar correo a: " . $this->user_email);

            Mail::to($this->user_email)->send(new PurchaseConfirmationMail($this->pdf_path));

            Log::info("Correo enviado correctamente a: " . $this->user_email);
        } catch (\Exception $e) {
            Log::error("Error enviando email: " . $e->getMessage());
        }
    }
}
