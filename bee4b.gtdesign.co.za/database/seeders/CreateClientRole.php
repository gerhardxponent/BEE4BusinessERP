<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateClientRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientRole = Role::create(['name' => 'Client']);
        $clientPermission = Permission::create(['name' => 'client']);

        $clientPermission->assignRole($clientRole);
    }
}
