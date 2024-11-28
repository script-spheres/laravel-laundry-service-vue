<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;

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
            UserSeeder::class,
            BannerSeeder::class,
            CouponSeeder::class,
            CustomerSeeder::class,
            FinancialYearSeeder::class,
            StoreSeeder::class,
            ServiceTypeSeeder::class,
            AddonServiceSeeder::class,
            ServiceItemSeeder::class,
        ]);
    }
}
