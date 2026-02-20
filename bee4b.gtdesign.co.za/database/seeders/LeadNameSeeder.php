<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leads = Lead::all();

        foreach ($leads as $lead) {
            $lead->name = $lead->first_name . ' ' . $lead->last_name;
            $lead->save();
        }
    }
}
