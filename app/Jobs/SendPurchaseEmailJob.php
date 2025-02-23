<?php

namespace App\Jobs;

use App\Mail\PurchaseConfirmationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPurchaseEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_email;

    /**
     * Crear una nueva instancia del job.
     */
    public function __construct($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * Ejecutar el job.
     */
    public function handle()
    {
        try {
            Log::info('Intentando enviar correo a: '.$this->user_email);

            Mail::to($this->user_email)->send(new PurchaseConfirmationMail);

            Log::info('Correo enviado correctamente a: '.$this->user_email);
        } catch (\Exception $e) {
            Log::error('Error enviando email: '.$e->getMessage());
        }
    }
}
