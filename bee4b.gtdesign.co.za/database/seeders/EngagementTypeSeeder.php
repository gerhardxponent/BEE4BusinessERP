<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EngagementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('engagement_types')->insert([
            ['name' => 'Monthly'],
            ['name' => 'Once-Off'],
            ['name' => 'Phased'],
        ]);
    }
}
