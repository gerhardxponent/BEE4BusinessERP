<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report_statuses')->insert([
            ['name' => 'Required'],
            ['name' => 'Review'],
            ['name' => 'TBC'],
            ['name' => 'To Draft'],
            ['name' => 'Update'],
            ['name' => 'Update'],
        ]);
    }
}
