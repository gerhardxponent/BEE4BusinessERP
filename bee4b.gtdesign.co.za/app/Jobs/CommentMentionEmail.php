<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CommentMentionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to_email, $fromUser, $emailBody, $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email, $fromUser, $emailBody, $link = '')
    {
        $this->to_email = $to_email;
        $this->fromUser = $fromUser; 
        $this->emailBody = $emailBody;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to_email = $this->to_email;

        Mail::send('mail', ['data' => $this->emailBody, 'link' => $this->link], function($message) use ($to_email) {
            $message->to($to_email)
                    ->subject($this->fromUser . ' mentioned you in comment');
        });
    }
}
