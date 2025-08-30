<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update a Super-Admin User
        $superAdmin = User::updateOrCreate(
            // Attributes to find the user by
            ['email' => 'shahzaib@majesticsofts.com'],
            // Attributes to create or update the user with
            [
                'name' => 'Super Admin',
                'role' => 'admin',
                'password' => Hash::make('password'), // Always reset password on seed
            ]
        );
        // Ensure the user has ONLY the 'super-admin' role
        $superAdmin->syncRoles('super-admin');


        // Create or update an Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                 'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles('admin');


        // Create or update a Customer User
        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                 'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );
        $customer->syncRoles('customer');
    }
}