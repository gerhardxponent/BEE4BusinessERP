<?php

namespace Database\Seeders;

use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PlannedAuditMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Clients::all() as $client) {
            if ($client->planned_audit_date) {
                $client->planned_audit_month_id = Carbon::parse($client->planned_audit_date)->month;
                $client->save();
            }
        }
    }
}
