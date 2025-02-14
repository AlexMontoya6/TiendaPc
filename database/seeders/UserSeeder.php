<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']); // Cambié 'UsuarioRegistrado' por 'Customer'

        // Crear usuarios con los roles adecuados
        // SuperAdmin (tiene todos los permisos)
        $superAdmin = User::factory()->create([
            'name' => 'SuperAdmin User',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadmin123'),
        ]);
        $superAdmin->assignRole($superAdminRole); // Asignar el rol SuperAdmin

        // Admin (tiene permisos de administración pero no todos)
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole($adminRole); // Asignar el rol Admin

        // Customer (tiene permisos básicos de usuario registrado en ecommerce)
        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@mail.com',
            'password' => bcrypt('customer123'),
        ]);
        $customer->assignRole($customerRole); // Asignar el rol Customer
    }
}
