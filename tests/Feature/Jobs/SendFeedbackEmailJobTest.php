<?php

use App\Jobs\SendFeedbackEmailJob;
use App\Mail\FeedbackEmail;
use Illuminate\Support\Facades\Mail;

it('envía un correo de feedback', function () {
    Mail::fake();

    dispatch(new SendFeedbackEmailJob('test@example.com'));

    Mail::assertSent(FeedbackEmail::class);
});
