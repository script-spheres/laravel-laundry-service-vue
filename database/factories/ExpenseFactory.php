<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 5, 500),
            'store_id' => Store::factory(),
            'receipt' => $this->faker->word,
        ];
    }
}
