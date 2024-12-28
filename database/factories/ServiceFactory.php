<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => $this->generateImage(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }


    /**
     * Generate image details.
     */
    private function generateImage(): array
    {
        $dirname = 'service-types';
        $storagePath = storage_path("app/public/$dirname");

        // Ensure the directory exists
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Generate the image file
        $filename = $this->faker->image($storagePath, 800, 600);

        return [
            'dirname' => $dirname,
            'basename' => $filename,
            'extension' => 'png',
            'location' => "$dirname/$filename",
            'url' => url("storage/$dirname/$filename"),
        ];
    }
}
