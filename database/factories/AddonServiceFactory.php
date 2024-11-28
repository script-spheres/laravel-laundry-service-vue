<?php

namespace Database\Factories;

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
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 5, 100),
            'active_status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
