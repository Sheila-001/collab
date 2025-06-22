<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Find user by email
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'class_year' => null,
                'email_verified_at' => now(),
            ]
        );

        // Create a backup admin account
        User::updateOrCreate(
            ['email' => 'superadmin@hauzhayag.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperAdmin@123'),
                'role' => 'admin',
                'status' => 'active',
                'class_year' => '2024',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'class_year' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
