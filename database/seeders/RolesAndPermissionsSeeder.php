<?php

// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

       // Looks for a role with name 'super-admin'. If it doesn't exist, it creates it.
        $superAdminRole = Role::updateOrCreate(['name' => 'super-admin']);

        // Looks for a role with name 'admin'. If it doesn't exist, it creates it.
        $adminRole = Role::updateOrCreate(['name' => 'admin']);

        // Looks for a role with name 'customer'. If it doesn't exist, it creates it.
        $customerRole = Role::updateOrCreate(['name' => 'customer']);

    }
}