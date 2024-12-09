<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use Alirezasedghi\LaravelImageFaker\Services\Picsum;
use App\Models\AddonService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AddonService>
 */
class AddonServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFaker = new ImageFaker(new Picsum());

        $storagePath = storage_path('app/public/addon-services');

        // Ensure the banners directory exists in the storage folder
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Generate image in the correct directory
        $filename = $imageFaker->image( $storagePath, 800, 600, false);

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => [
                'dirname' => 'addon-services',
                'basename' => $filename,
                'extension' => 'jpg',
                'location' => 'addon-services/' . $filename,
                'url' => url('storage/addon-services/' . $filename),
            ],
            'price' => $this->faker->randomFloat(2, 5, 100),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
