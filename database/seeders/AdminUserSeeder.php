<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gruasalonso.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@gruasalonso.com',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Local',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ]
        );
    }
}
