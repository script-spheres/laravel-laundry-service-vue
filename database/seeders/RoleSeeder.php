<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Role - Full access
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Manager Role - Can manage orders, assign tasks, view reports, manage customers, and manage finances
        $managerRole = Role::updateOrCreate(['name' => 'manager']);

        // Accountant Role - Manages finances, expenses, and generates financial reports
        $accountantRole = Role::updateOrCreate(['name' => 'accountant']);
    }
}
