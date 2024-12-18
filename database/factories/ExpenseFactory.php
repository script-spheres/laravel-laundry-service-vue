<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\ExpenseType;
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
            'expense_type_id' => ExpenseType::factory(),
            'store_id' => Store::factory(),
            'date' => $this->faker->date,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'note' => $this->faker->paragraph,
        ];
    }
}
