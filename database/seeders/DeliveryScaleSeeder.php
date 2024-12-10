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
// Define predefined delivery scale data without the 'name' field
        $deliveryScales = collect([
            [
                'radius' => 5,
                'radius_unit' => 'km',
                'min_order_amount' => 50.00,
                'delivery_charges' => 10.00,
            ],
            [
                'radius' => 10,
                'radius_unit' => 'km',
                'min_order_amount' => 100.00,
                'delivery_charges' => 20.00,
            ],
            [
                'radius' => 20,
                'radius_unit' => 'km',
                'min_order_amount' => 150.00,
                'delivery_charges' => 35.00,
            ],
            [
                'radius' => 30,
                'radius_unit' => 'km',
                'min_order_amount' => 200.00,
                'delivery_charges' => 50.00,
            ],
            [
                'radius' => 50,
                'radius_unit' => 'km',
                'min_order_amount' => 300.00,
                'delivery_charges' => 80.00,
            ],
        ]);

        // Create each delivery scale record without the 'name' field
        $deliveryScales->each(fn($scale) => DeliveryScale::create($scale));
    }
}
