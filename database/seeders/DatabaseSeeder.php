<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            ServiceItemSeeder::class,
            UnitSeeder::class,
            ExpenseTypeSeeder::class,
            OrderLabelSeeder::class,
            TimeslotSeeder::class,
            DeliveryScaleSeeder::class,
        ]);
    }
}
