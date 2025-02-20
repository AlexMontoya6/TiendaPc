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
        // Enviar el correo con el PDF adjunto
        Mail::to($this->user_email)->send(new PurchaseConfirmationMail($this->pdf_path));
    }
}
