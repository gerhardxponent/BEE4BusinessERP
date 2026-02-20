<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PhasePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phases = Phase::all();
        $adminRole = Role::findByName('Administrator');

        foreach ($phases as $phase) {
            $newPermission = Permission::create([
                'name' => 'view ' . $phase->name
            ]);
            $newPermission->assignRole($adminRole);
        }
    }
}
