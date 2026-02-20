<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lead_statuses')->insert([
            ['name' => 'active', 'colour' => '#22c55e'],
            ['name' => 'pending', 'colour' => '#f59e0b'],
            ['name' => 'cancelled', 'colour' => '#ef4444'],
        ]);
    }
}
