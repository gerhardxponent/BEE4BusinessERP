<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BasicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basicRole = Role::create(['name' => 'Basic']);
        $operation = 'view';
        $modules = ['clients', 'contacts', 'quotes', 'products', 'services'];
        foreach($modules as $m) {
            $perm = Permission::findByName($operation . ' ' . $m);
            $basicRole->givePermissionTo($perm);
        }

        $basicUser = User::factory()->create([
            'email' => 'basic@gmail.com',
            'password' => bcrypt('password')
        ]);
        $basicUser->assignRole($basicRole);
    }
}
