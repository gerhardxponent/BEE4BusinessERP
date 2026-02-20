<?php

namespace App\Mail;

use App\Models\Audit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditFinalThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public Audit $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function build()
    {
        $clientName = $this->audit->client()->withTrashed()->first()->name;
        $auditName  = $this->audit->name;
        $year       = optional($this->audit->planned_audit_date)->year ?? now()->year;

        return $this
            ->subject("All documents received for {$clientName} – {$auditName} FY{$year}")
            ->markdown('emails.audits.final_thank_you', [
                'clientName' => $clientName,
                'auditName'  => $auditName,
                'year'       => $year,
                'audit'      => $this->audit,
            ]);
    }
}
