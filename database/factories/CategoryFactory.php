<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use Alirezasedghi\LaravelImageFaker\Services\Picsum;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    function definition(): array
    {
        $imageFaker = new ImageFaker(new Picsum());

        $storagePath = storage_path('app/public/categories');

        // Ensure the categories directory exists in the storage folder
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Generate image in the correct directory
        $filename = $imageFaker->image($storagePath, 800, 600, false);

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'image' => [
                'dirname' => 'categories',
                'basename' => $filename,
                'extension' => 'jpg',
                'location' => 'categories/' . $filename,
                'url' => url('storage/categories/' . $filename),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
