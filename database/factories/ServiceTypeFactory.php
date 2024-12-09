<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use Alirezasedghi\LaravelImageFaker\Services\Picsum;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceType>
 */
class ServiceTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFaker = new ImageFaker(new Picsum());

        $storagePath = storage_path('app/public/service-types');

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
                'dirname' => 'service-types',
                'basename' => $filename,
                'extension' => 'jpg',
                'location' => 'service-types/' . $filename,
                'url' => url('storage/service-types/' . $filename),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
