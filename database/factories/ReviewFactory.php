<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_type' => Order::class,
            'model_id' => Order::factory(),
            'author_type' => User::class,
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'review' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'in_testimonial' => $this->faker->boolean(),
        ];
    }
}
