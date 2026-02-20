<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LeadPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::findByName('Administrator');
        $operations = ['create', 'view', 'edit', 'delete'];
        foreach($operations as $op) {
            $newPerm = Permission::create(['name' => $op . ' leads']);
            $newPerm->assignRole($admin);
        }
    }
}
