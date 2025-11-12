<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@caartl.com'],
            [
                'name' => 'Super Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->syncRoles(['super-admin']); // API guard automatically used from User model

        // 2️⃣ Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['admin']);

        // 3️⃣ Customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );
        $customer->syncRoles(['customer']);
        
    }
}
