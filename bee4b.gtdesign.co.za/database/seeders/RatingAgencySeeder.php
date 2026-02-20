<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rating_agencies')->insert([
            ['name' => '5Star'],
            ['name' => 'aBEERate'],
            ['name' => 'AMAX'],
            ['name' => 'BDO'],
            ['name' => 'BEE Rated'],
            ['name' => 'BEE Score'],
            ['name' => 'Mazars'],
            ['name' => 'Renaissance'],
            ['name' => 'Vision Verification'],
        ]);
    }
}
