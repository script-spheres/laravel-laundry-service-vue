<?php

namespace Database\Factories;

use App\Models\DeliveryScale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeliveryScale>
 */
class DeliveryScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'radius' => $this->faker->randomFloat(2, 1, 100),
            'radius_unit' => $this->faker->randomElement(['km', 'miles']),
            'min_order_amount' => $this->faker->randomFloat(2, 1, 100),
            'delivery_charges' => $this->faker->randomFloat(2, 5, 20),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
