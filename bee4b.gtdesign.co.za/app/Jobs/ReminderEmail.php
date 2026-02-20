<?php

namespace App\Jobs;

use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $audits = Audit::query()
            ->whereHas('auditFiles', fn($query) => $query->whereBetween('due_date', [Carbon::now()->subDays(1), Carbon::now()->addDays(30)]))
            ->with('auditFiles', fn($query) => $query->whereBetween('due_date', [Carbon::now()->subDays(1), Carbon::now()->addDays(30)]))
            ->with('mailList')
            ->get();
        
        $to_email = 'keshav.badul06@gmail.com';

        Mail::send('email-templates.reminder', ['data' => $audits], function($message) use ($to_email) {
            $message->to($to_email)
                    ->subject('test email');
        });
    }
}
