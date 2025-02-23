<?php

namespace Tests\Traits;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;

trait CreatesUsers
{
    public function loginAsUser(): User
    {
        $user = User::factory()->create();

        // Asegurar que el rol "Customer" existe en `web` y `api`
        $roleWeb = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'web']);
        $roleApi = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'api']);
        $user->syncRoles([$roleWeb, $roleApi]);

        actingAs($user);

        return $user;
    }

    public function actingAsSuperAdmin(): User
    {
        // Definir los permisos para web
        $permissions = [
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver pedidos',
            'gestionar pedidos',
            'eliminar pedidos',
        ];

        // Crear permisos si no existen (en web)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear rol SuperAdmin si no existe en web y asignarle permisos
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::where('guard_name', 'web')->get()); // 🔥 Ahora sí asignamos permisos en web

        // Crear el usuario y asignarle el rol de SuperAdmin
        $admin = User::factory()->create();
        $admin->assignRole($superAdminRole);
        $admin->syncPermissions(Permission::where('guard_name', 'web')->get()); // 🔥 Aseguramos permisos en la tabla pivot

        // Autenticar como el SuperAdmin recién creado
        actingAs($admin, 'web'); // 🔥 Usamos el guard web

        return $admin;
    }
}
