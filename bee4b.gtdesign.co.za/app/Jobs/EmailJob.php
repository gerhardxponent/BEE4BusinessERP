<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $toEmail, $ccEmail, $fromUser, $subject, $content, $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($toEmail = '', $ccEmail = null, $fromUser = '', $subject = '', $content = '', $link = '')
    {
        $this->toEmail = $toEmail;
        $this->ccEmail = $ccEmail;
        $this->fromUser = $fromUser;
        $this->subject = $subject;
        $this->content = $content;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $test = false;

        Mail::send('mail', ['data' => $this->content, 'link' => $this->link], function($message) use($test) {
            $message
                ->to($this->toEmail)
                ->subject($this->subject);

            if ($this->ccEmail != null) {
                $message->cc($this->ccEmail);
            }
        });

        // if ($test) {
        //     Mail::send('mail', ['data' => $this->content, 'link' => $this->link], function($message) {
        //         $message
        //             ->to($this->toEmail)
        //             ->subject($this->subject);
        //     });
        // } else {
        //     Mail::send('mail', ['data' => $this->content, 'link' => $this->link], function($message) use($test) {
        //         $message
        //             ->to($this->toEmail)
        //             ->cc($this->ccEmail)
        //             ->subject($this->subject);
        //     });
        // }
    }
}
