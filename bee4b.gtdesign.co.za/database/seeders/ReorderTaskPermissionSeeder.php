<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReorderTaskPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::findByName('Administrator');

        $newPermission = Permission::create([
            'name' => 'reorder tasks'
        ]);
        $newPermission->assignRole($adminRole);
    }
}
