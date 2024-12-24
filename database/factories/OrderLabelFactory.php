<?php

namespace Database\Factories;

use App\Models\OrderLabel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderLabel>
 */
class OrderLabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
