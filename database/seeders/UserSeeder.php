<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;                  // ✅ IMPORTANTE
use Illuminate\Support\Facades\Hash;  // ✅ IMPORTANTE

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // EMPLEADO
        User::create([
            'name' => 'Empleado',
            'email' => 'empleado@empresa.com',
            'password' => Hash::make('empleado123'),
            'role' => 'empleado',
        ]);
    }
}
