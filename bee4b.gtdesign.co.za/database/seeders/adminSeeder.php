<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Administrator']);
        $operations = ['create', 'view', 'edit', 'delete'];
        $modules = ['clients', 'contacts'];

        foreach($modules as $module) {
            foreach($operations as $operation) {
                $newPermission = Permission::find(['name' => $operation . ' ' . $module]);
                $newPermission->assignRole($adminRole);
            }
        }

        $adminUser = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $adminUser->assignRole($adminRole);
    }
}
