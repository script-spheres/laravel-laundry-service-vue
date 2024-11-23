<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Store;
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
            'service_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'store_id' => Store::factory(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
