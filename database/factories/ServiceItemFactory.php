<?php

namespace Database\Factories;

use App\Models\ServiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Intervention\Image\Laravel\Facades\Image;

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
        $dirname = 'service-items';
        $storagePath = storage_path("app/public/$dirname");

        // Ensure the directory exists
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Define a unique filename for the image
        $filename = $this->faker->uuid . '.png';

        // Create a blank image with Intervention Image
        $img = Image::create(400, 400)->fill('#cccccc');

        // Save the image to the storage path
        $img->save($storagePath . DIRECTORY_SEPARATOR . $filename);

        return [
            'dirname' => $dirname,
            'basename' => $filename,
            'extension' => 'png',
            'location' => "$dirname/$filename",
            'url' => url("storage/$dirname/$filename"),
        ];
    }
}
