<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
{
    $roles = [
        'SuperAdmin' => ['web', 'api'],
        'Admin' => ['web'], // 🔥 Solo en web
        'Customer' => ['web', 'api'],
    ];

    foreach ($roles as $role => $guards) {
        foreach ($guards as $guard) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => $guard]);
        }
    }

    // Asignamos los roles correctamente
    $superAdmin = User::factory()->create([
        'name' => 'SuperAdmin User',
        'email' => 'superadmin@mail.com',
        'password' => bcrypt('superadmin123'),
    ]);
    $superAdmin->assignRole(['SuperAdmin']); // 🔥 Ahora se asigna bien

    $admin = User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@mail.com',
        'password' => bcrypt('admin123'),
    ]);
    $admin->assignRole('Admin'); // 🔥 Rol Admin para WEB

    $customer = User::factory()->create([
        'name' => 'Customer User',
        'email' => 'customer@mail.com',
        'password' => bcrypt('customer123'),
    ]);
    $customer->assignRole(['Customer']);
}

}
