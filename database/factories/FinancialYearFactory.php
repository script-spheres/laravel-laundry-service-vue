<?php

namespace Database\Factories;

use App\Models\FinancialYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FinancialYear>
 */
class FinancialYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Financial Year',
            'description' => $this->faker->text(200),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
