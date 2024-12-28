<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = collect([
            ['name' => 'Dry Cleaning', 'description' => 'Expert cleaning for all types of garments, removing stains and dirt with care.'],
            ['name' => 'Premium Laundry Kg', 'description' => 'High-quality laundry services for clothes, priced by weight.'],
            ['name' => 'Laundry - Wash & Fold', 'description' => 'Wash and fold service for your laundry, ensuring a neat and wrinkle-free finish.'],
            ['name' => 'Laundry - Wash & Iron', 'description' => 'Wash and iron service for clothes, providing a crisp and professional finish.'],
            ['name' => 'Steam Press', 'description' => 'Steam pressing service to remove wrinkles from clothes and fabrics, giving them a polished look.'],
            ['name' => 'Shoe Cleaning', 'description' => 'Cleaning and restoring your shoes to their original condition, for a refreshed look.'],
            ['name' => 'Bag Cleaning', 'description' => 'Thorough cleaning of bags, including leather and fabric, ensuring a like-new appearance.'],
            ['name' => 'Sofa Cleaning', 'description' => 'Deep cleaning of your sofa and upholstery, removing dirt and stains for a fresh look.'],
            ['name' => 'Carpet Cleaning', 'description' => 'Expert cleaning of carpets to remove dirt, stains, and odors, restoring their original beauty.'],
        ]);

        // Insert each service with both name and description
        $services->each(fn($service) => Service::factory()->create([
            'name' => $service['name'],
            'description' => $service['description'],
        ]));
    }
}
