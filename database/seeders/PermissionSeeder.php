<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::where('name', 'Admin')->first();
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();

        if ($adminRole) {
            $adminRole->syncPermissions(array_merge($productPermissions, $orderPermissions));
        }

        if ($superAdminRole) {
            $superAdminRole->syncPermissions(Permission::all());
        }
    }
}
