<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use Alirezasedghi\LaravelImageFaker\Services\Picsum;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFaker = new ImageFaker(new Picsum());

        $storagePath = storage_path('app/public/banners');

        // Ensure the banners directory exists in the storage folder
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Generate image in the correct directory
        $filename = $imageFaker->image( $storagePath, 800, 600, false);

        return [
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'image' => [
                'dirname' => 'banners',
                'basename' => $filename,
                'extension' => 'jpg',
                'location' => 'banners/' . $filename,
                'url' => url('storage/banners/' . $filename),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
