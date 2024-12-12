<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'actual_name' => $this->faker->word,
            'short_name' => $this->faker->lexify('??'),
            'allow_decimal' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
