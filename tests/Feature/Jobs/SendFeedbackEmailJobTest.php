<?php

use App\Jobs\SendFeedbackEmailJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackEmail;

it('envía un correo de feedback', function () {
    Mail::fake();

    dispatch(new SendFeedbackEmailJob('test@example.com'));

    Mail::assertSent(FeedbackEmail::class);
});
