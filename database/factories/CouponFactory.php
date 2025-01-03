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
            'discount_percentage' => $this->faker->randomFloat(2, 1, 99),
            'max_discount_amount' => $this->faker->randomFloat(2, 1, 100),
            'min_order_amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
