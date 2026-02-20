<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditUploadReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $audit, $files;

    public function __construct($user, $audit, $files)
    {
        $this->user = $user;
        $this->audit = $audit;
        $this->files = $files;
    }

    public function build()
    {
        return $this->subject("Reminder: Upload Files for Audit '{$this->audit->name}'")
                    ->view('emails.audit-upload-reminder');
    }
}
