<?php

namespace Database\Seeders;

use App\Models\Colour;
use Illuminate\Database\Seeder;

class ColourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Colour::insert(
            ['code' => '#f1f5f9'],
            ['code' => '#fee2e2'],
            ['code' => '#ffedd5'],
            ['code' => '#f1f5f9'],
            ['code' => '#f1f5f9'],
        );
    }
}
