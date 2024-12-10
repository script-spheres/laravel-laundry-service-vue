<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeNames = collect([
            'Clean Clothes Laundry',
            'Fresh Fold Laundry',
            'QuickWash Laundry',
            'Speedy Laundry Service',
            'Laundry Express',
            'Deluxe Laundry Service',
            'Eco Fresh Laundry',
            'Perfect Press Laundry',
            'The Laundry Spot',
            'Green Wash Laundry',
        ]);

        $storeNames->each(fn($name) => Store::factory()->create(['name' => $name]));
    }
}
