<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            'Mens',
            'Women\'s',
            'Household',
            'Kids',
        ]);

        $categories->each(fn($name) => Category::factory()->create(['name' => $name]));
    }
}
