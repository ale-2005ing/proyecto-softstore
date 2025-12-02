<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $admin->syncRoles(['admin']);

        // EMPLEADO
        $empleado = User::firstOrCreate(
            ['email' => 'empleado@empresa.com'],
            [
                'name' => 'Empleado',
                'password' => Hash::make('empleado123'),
            ]
        );

        $empleado->syncRoles(['empleado']);

        $this->command->info('✅ Usuarios creados/actualizados correctamente');
    }
}