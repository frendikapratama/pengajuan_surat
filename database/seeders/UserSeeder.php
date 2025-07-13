<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('user12345'),
            'role' => 'user',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('superadmin12345'),
            'role' => 'super_admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);
    }
}
