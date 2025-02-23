<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    public function build()
    {
        return $this->subject('Valora tu experiencia con nosotros')
            ->markdown('emails.feedback');

    }
}
