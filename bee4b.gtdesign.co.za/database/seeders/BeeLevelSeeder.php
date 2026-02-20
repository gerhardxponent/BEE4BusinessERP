<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bee_levels')->insert([
            ['name' => 'Non-Compliant'],
            ['name' => 'Level 1'],
            ['name' => 'Level 2'],
            ['name' => 'Level 3'],
            ['name' => 'Level 4'],
            ['name' => 'Level 5'],
            ['name' => 'Level 6'],
            ['name' => 'Level 7'],
            ['name' => 'Level 8'],
        ]);
    }
}
