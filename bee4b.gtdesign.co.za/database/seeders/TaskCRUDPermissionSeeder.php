<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TaskCRUDPermissionSeeder extends Seeder
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
        $modules = ['tasks'];

        foreach($modules as $module) {
            foreach($operations as $op) {
                $newPermission = Permission::create([
                    'name' => $op . ' ' . $module
                ]);
                $newPermission->assignRole($adminRole);
            }
        }

        Module::insert([
            'name' => 'tasks'
        ]);
    }
}
