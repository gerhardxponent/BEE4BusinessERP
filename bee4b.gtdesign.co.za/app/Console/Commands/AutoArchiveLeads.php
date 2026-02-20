<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use Carbon\Carbon;

class AutoArchiveLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:auto-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically archive leads that are older than 6 months and not converted';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        // Find leads older than 6 months that are not converted (client_id is NULL)
        $leadsToArchive = Lead::whereNull('client_id')
            ->whereNull('deleted_at') // Ensure it's not already deleted
            ->where('created_at', '<', $sixMonthsAgo)
            ->get();

        $count = $leadsToArchive->count();

        if ($count === 0) {
            $this->info("✅ No leads need to be archived.");
            return;
        }

        foreach ($leadsToArchive as $lead) {
            $lead->lead_status_id = null;  // Clear status
            $lead->deleted_at = now();     // Set deleted timestamp
            $lead->save();
        }

        $this->info("✅ Successfully archived {$count} leads older than 6 months.");
    }
}
