<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'code' => strtoupper(Str::random(6)),
            'discount_type' => $this->faker->randomElement(['flat', 'percentage']),
            'discount_amount' => $this->faker->optional()->randomFloat(2, 1, 100),
            'discount_percentage' => $this->faker->optional()->randomFloat(2, 1, 100),
            'min_amount' => $this->faker->randomFloat(2, 10, 1000),
            'max_amount' => $this->faker->randomFloat(2, 10, 1000),
            'valid_from' => $this->faker->date(),
            'valid_to' => $this->faker->date(),
            'usage_limit' => $this->faker->optional()->numberBetween(1, 100),
            'used_count' => $this->faker->numberBetween(0, 10),
            'active_status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
