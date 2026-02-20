<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendLeadFollowUpEmails extends Command
{
    protected $signature = 'leads:send-followup-emails';
    protected $description = 'Send follow-up emails for leads created 14 days ago and every 14 days thereafter';

    public function handle()
    {
        $leads = Lead::whereNull('archived_at') // Only active leads
            ->whereRaw("DATEDIFF(NOW(), created_at) % 14 = 0") // Check if it's a multiple of 14 days
            ->get();

        foreach ($leads as $lead) {
            Mail::send([], [], function ($message) use ($lead) {
                $message->to('admin@bee4business.co.za')
                    ->cc('xiiphoid@gmail.com')
                    ->subject("Follow-up on Lead: {$lead->name}")
                    ->setBody("Reminder: Please follow up on the lead: {$lead->name} ({$lead->email_address}). Created on: {$lead->created_at->format('Y-m-d')}", 'text/html');
            });
        }

        $this->info('Follow-up emails sent successfully.');
    }
}