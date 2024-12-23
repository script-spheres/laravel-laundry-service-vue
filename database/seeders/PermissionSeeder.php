<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            'index',
            'show',
            'create',
            'edit',
            'delete',
        ];

        $resources = [
            'banner',
            'delivery-scale',
            'redemption',
            'reward',
            'point',
            'city',
            'category',
            'unit',
            'store',
            'customer',
            'service',
            'service-item',
            'addon-service',
            'coupon',
            'timeslot',
            'order',
            'expense',
            'expense-type',
            'financial-year',
            'role',
            'user',
        ];

        // Generate permissions for each resource and action
        collect($resources)
            ->crossJoin($actions)
            ->map(function ($set) {
                return implode('.', $set);
            })
            ->each(function ($permission) {
                Permission::updateOrCreate(['name' => $permission]);
            });

        // Additional permissions for specific routes
        $additionalPermissions = [
            'orders.invoice',
            'orders-status.index',
            'orders-status.update',
            'settings.index',
            'settings.submit',
            'settings.finance',
            'reports.financial',
            'reports.orders',
            'reports.customers',
            'reports.inventory',
            'reports.expenses',
            'reports.sales',
            'reports.profits',
        ];

        foreach ($additionalPermissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
