<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('audit_progress')->insert([
            ['name' => 'Request Quote'],
            ['name' => 'Engaged'],
            ['name' => 'Request Quote'],
        ]);
    }
}
