<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productPermissions = [
            'crear productos',
            'editar productos',
            'eliminar productos',
        ];

        $userPermissions = [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
        ];

        $orderPermissions = [
            'ver pedidos',
            'gestionar pedidos',
            'eliminar pedidos',
        ];

        $allPermissions = array_merge($productPermissions, $userPermissions, $orderPermissions);

        // CREAR PERMISOS PARA WEB Y API
        foreach ($allPermissions as $permission) {
            // Permiso para la web
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);

            // Permiso para la API
            Permission::firstOrCreate([
                'name' => "api.$permission", // Prefijo para diferenciar los de la API
                'guard_name' => 'api'
            ]);
        }

        // CREAR ROLES PARA WEB Y API
        $adminRoleWeb = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRoleApi = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);

        $superAdminRoleWeb = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $superAdminRoleApi = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'api']);

        // ASIGNAR PERMISOS A LOS ROLES
        $adminRoleWeb->syncPermissions(array_merge($productPermissions, $orderPermissions));
        $adminRoleApi->syncPermissions(array_map(fn ($p) => "api.$p", array_merge($productPermissions, $orderPermissions)));

        $superAdminRoleWeb->syncPermissions(Permission::where('guard_name', 'web')->get());
        $superAdminRoleApi->syncPermissions(Permission::where('guard_name', 'api')->get());
    }
}
