<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SupplierPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::findByName('Administrator');
        $operations = ['create', 'view', 'edit', 'delete'];

        foreach($operations as $op) {
            $newPermission = Permission::create(['name' => $op . ' suppliers']);
            $newPermission->assignRole($adminRole);
        }
    }
}
