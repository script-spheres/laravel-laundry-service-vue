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
            UserSeeder::class,
            CategorySeeder::class,
            CitySeeder::class,
            UnitSeeder::class,
            BannerSeeder::class,
            CouponSeeder::class,
            CustomerSeeder::class,
            FinancialYearSeeder::class,
            StoreSeeder::class,
            ServiceSeeder::class,
            AddonServiceSeeder::class,
            ServiceItemSeeder::class,
            ServiceDetailSeeder::class,
            OrderSeeder::class,
            TimeslotSeeder::class,
            DeliveryScaleSeeder::class,
        ]);
    }
}
