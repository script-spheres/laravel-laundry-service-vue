<?php

namespace Database\Factories;

use App\Models\ServiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceItem>
 */
class ServiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $storagePath = storage_path('app/public/service-items');

        // Ensure the banners directory exists in the storage folder
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Generate image in the correct directory
        $filename = $this->faker->image($storagePath, 800, 600, 'business', false);

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => [
                'dirname' => 'service-items',
                'basename' => $filename,
                'extension' => 'jpg',
                'location' => 'service-items/' . $filename,
                'url' => url('storage/service-items/' . $filename),
            ],
            'active_status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
