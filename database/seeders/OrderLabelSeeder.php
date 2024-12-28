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
        $storeNames = collect(['pending', 'in-progress', 'ready-to-deliver', 'delivered']);

        $storeNames->each(fn($name) => OrderLabel::factory()->create(['name' => $name]));
    }
}
