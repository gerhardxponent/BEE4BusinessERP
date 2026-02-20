<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditSummaryReport extends Mailable
{
    use Queueable, SerializesModels;

    public $audit;
    public $fileName;

    public function __construct($audit, $fileName)
    {
        $this->audit = $audit;
        $this->fileName = $fileName;
    }

    public function build()
    {
        return $this->subject("Audit Summary Report: {$this->audit->name}")
                    ->view('emails.audit-summary2')
                    ->attach(storage_path("app/public/reports/{$this->fileName}"));
    }
}
