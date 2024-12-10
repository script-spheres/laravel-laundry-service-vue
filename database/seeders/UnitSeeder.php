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
            'kg',
            'g',
            'liter',
            'ml',
            'pcs',
            'dozen',
            'ton',
            'mg',
            'm²',
            'cm',
        ]);

        $unitNames->each(fn($name) => Unit::factory()->create(['name' => $name]));
    }
}
