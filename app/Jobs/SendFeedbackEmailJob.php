<?php

namespace App\Jobs;

use App\Mail\FeedbackEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_email;

    /**
     * Create a new job instance.
     */
    public function __construct($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user_email)->send(new FeedbackEmail);
    }
}
