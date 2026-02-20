<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phases = [
            'Lead', 'Engagement', 'Planning', 'Implementation', 'Review', 'Pre-Audit', 'Verification', 'Admin'
        ];

        foreach($phases as $phase) {
            $newPhase = Phase::make();

            $newPhase->name = $phase;

            $newPhase->save();
        }
    }
}
