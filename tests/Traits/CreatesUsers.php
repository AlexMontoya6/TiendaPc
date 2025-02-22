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

        // Asegurar que el rol "Customer" existe
        $role = Role::firstOrCreate(['name' => 'Customer']);
        $user->assignRole($role);

        actingAs($user);

        auth()->user();
        return $user;
    }

    public function actingAsSuperAdmin(): User
{
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
        'eliminar pedidos'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);

    if (!$superAdminRole->hasPermissionTo($permissions[0])) {
        $superAdminRole->syncPermissions(Permission::all());
    }

    $admin = User::factory()->create();
    $admin->assignRole('SuperAdmin');
    $admin->refresh(); // 🔹 Refrescar el modelo para asegurar que tiene el rol

    $this->actingAs($admin); // ✅ Esto sí funciona en tests

    return $admin;
}

}
