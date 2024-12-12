<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitNames = collect([
            ['actual_name' => 'Kilogram', 'short_name' => 'kg', 'allow_decimal' => true],
            ['actual_name' => 'Gram', 'short_name' => 'g', 'allow_decimal' => true],
            ['actual_name' => 'Liter', 'short_name' => 'L', 'allow_decimal' => true],
            ['actual_name' => 'Milliliter', 'short_name' => 'mL', 'allow_decimal' => true],
            ['actual_name' => 'Piece', 'short_name' => 'pcs', 'allow_decimal' => false],
            ['actual_name' => 'Dozen', 'short_name' => 'dz', 'allow_decimal' => false],
            ['actual_name' => 'Ton', 'short_name' => 't', 'allow_decimal' => true],
            ['actual_name' => 'Milligram', 'short_name' => 'mg', 'allow_decimal' => true],
            ['actual_name' => 'Square Meter', 'short_name' => 'm²', 'allow_decimal' => true],
            ['actual_name' => 'Centimeter', 'short_name' => 'cm', 'allow_decimal' => true],
        ]);

        $unitNames->each(fn($data) => Unit::factory()->create($data));
    }
}
