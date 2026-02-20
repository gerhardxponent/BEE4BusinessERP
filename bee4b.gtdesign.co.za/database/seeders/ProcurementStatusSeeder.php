<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcurementStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('procurement_statuses')->insert([
            ['name' => 'inactive'],
            ['name' => 'active'],
            ['name' => 'complete']
        ]);
    }
}
