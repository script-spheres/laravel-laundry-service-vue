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
        $serviceNames = collect([
            'Dry Cleaning',
            'Premium Laundry Kg',
            'Laundry - Wash & Fold',
            'Laundry - Wash & Iron',
            'Steam Press',
        ]);

        $serviceNames->each(fn($name) => Service::factory()->create(['name' => $name]));
    }
}
