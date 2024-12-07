<?php

namespace Database\Seeders;

use App\Models\DeliveryScale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryScale::factory()->count(10)->create();
    }
}
