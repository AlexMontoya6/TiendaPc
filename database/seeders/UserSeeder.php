<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);

        $superAdmin = User::factory()->create([
            'name' => 'SuperAdmin User',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadmin123'),
        ]);
        $superAdmin->syncRoles([$superAdminRole]); // ← 🔥 Esto elimina cualquier otro rol

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->syncRoles([$adminRole]); // ← 🔥 Esto elimina cualquier otro rol

        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@mail.com',
            'password' => bcrypt('customer123'),
        ]);
        $customer->syncRoles([$customerRole]); // ← 🔥 Esto elimina cualquier otro rol
    }
}
