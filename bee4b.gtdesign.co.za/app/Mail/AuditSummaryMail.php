<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $audit;
    public $auditData;

    /**
     * Create a new message instance.
     */
    public function __construct($audit, $auditData)
    {
        $this->audit = $audit;
        $this->auditData = $auditData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.audit-summary')
            ->subject("Audit Summary Report: {$this->audit->name}")
            ->with([
                'auditName' => $this->audit->name,
                'clientName' => $this->audit->client->name,
                'auditData' => $this->auditData,
            ]);
    }
}
