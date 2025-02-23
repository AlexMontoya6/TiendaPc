<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // OBTENER ROLES PARA WEB
        $superAdminRoleWeb = Role::where('name', 'SuperAdmin')->where('guard_name', 'web')->first();
        $adminRoleWeb = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        $customerRoleWeb = Role::where('name', 'Customer')->where('guard_name', 'web')->first();

        // OBTENER ROLES PARA API
        $superAdminRoleApi = Role::where('name', 'SuperAdmin')->where('guard_name', 'api')->first();
        $adminRoleApi = Role::where('name', 'Admin')->where('guard_name', 'api')->first();
        $customerRoleApi = Role::where('name', 'Customer')->where('guard_name', 'api')->first();

        // SUPER ADMIN (WEB + API)
        $superAdmin = User::factory()->create([
            'name' => 'SuperAdmin User',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadmin123'),
        ]);
        $superAdmin->syncRoles([$superAdminRoleWeb, $superAdminRoleApi]);

        // ADMIN (SOLO WEB)
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->syncRoles([$adminRoleWeb]);

        // CUSTOMER (SOLO WEB + API)
        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@mail.com',
            'password' => bcrypt('customer123'),
        ]);
        $customer->syncRoles([$customerRoleWeb, $customerRoleApi]);
    }
}
