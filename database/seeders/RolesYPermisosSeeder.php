<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $empleado = Role::firstOrCreate(['name' => 'empleado']);

        // Permisos REALES según tus rutas
        $permisos = [

            // Panel
            'admin.panel',
            'empleado.panel',

            // Ventas
            'ventas.index',
            'ventas.create',
            'ventas.store',
            'ventas.show',
            'ventas.edit',
            'ventas.update',
            'ventas.destroy',
            'ventas.factura',
            'ventas.pdf',
            'ventas.ver-pdf',

            // Productos
            'productos.index',
            'productos.show',
            'productos.create',
            'productos.edit',
            'productos.update',
            'productos.destroy',

            // Clientes
            'clientes.index',
            'clientes.show',
            'clientes.create',
            'clientes.store',
            'clientes.edit',
            'clientes.update',
            'clientes.destroy',

            // Categorías
            'categorias.index',
            'categorias.create',
            'categorias.store',
            'categorias.edit',
            'categorias.update',
            'categorias.destroy',

            // Proveedores
            'proveedores.index',
            'proveedores.create',
            'proveedores.store',
            'proveedores.edit',
            'proveedores.update',
            'proveedores.destroy',

            // Entradas
            'entradas.index',
            'entradas.create',
            'entradas.store',
            'entradas.show',
            'entradas.edit',
            'entradas.update',
            'entradas.destroy',

            // Reportes
            'reportes.index',

            // Usuarios
            'usuarios.index',
            'usuarios.create',
            'usuarios.store',
            'usuarios.edit',
            'usuarios.update',
            'usuarios.destroy',

            // Notificaciones
            'notificaciones.index',
            'notificaciones.marcarLeida',
            'notificaciones.marcarTodasLeidas',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ADMIN → todos los permisos
        $admin->syncPermissions(Permission::all());

        // EMPLEADO → permisos limitados
        $empleado->syncPermissions([
            // Panel
            'empleado.panel',

            // Ventas (completo)
            'ventas.index',
            'ventas.create',
            'ventas.store',
            'ventas.show',
            'ventas.edit',
            'ventas.update',
            'ventas.factura',
            'ventas.pdf',
            'ventas.ver-pdf',
            // NO 'ventas.destroy' - no puede eliminar ventas antiguas

            // Productos (solo lectura)
            'productos.index',
            'productos.show',
            // NO puede crear, editar ni eliminar productos

            // Clientes (sin eliminar)
            'clientes.index',
            'clientes.show',
            'clientes.create',
            'clientes.store',
            'clientes.edit',
            'clientes.update',
            // NO 'clientes.destroy' - no puede eliminar clientes

            // Notificaciones
            'notificaciones.index',
            'notificaciones.marcarLeida',
            'notificaciones.marcarTodasLeidas',
        ]);

        $this->command->info('✅ Roles y permisos actualizados correctamente');
    }
}