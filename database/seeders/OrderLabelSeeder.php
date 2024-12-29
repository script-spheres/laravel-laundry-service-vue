<?php

namespace Database\Seeders;

use App\Models\OrderLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeNames = collect([
            ['name' => 'pending', 'description' => 'Order is waiting to be processed'],
            ['name' => 'in-progress', 'description' => 'Order is being processed'],
            ['name' => 'ready-to-deliver', 'description' => 'Order is ready for delivery'],
            ['name' => 'delivered', 'description' => 'Order has been delivered'],
        ]);

        $storeNames->each(fn($store) => OrderLabel::factory()->create([
            'name' => $store['name'],
            'description' => $store['description'],
        ]));
    }
}
