<?php

namespace Database\Factories;

use App\Models\FinancialYear;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'address_lat' => $this->faker->latitude,
            'address_long' => $this->faker->longitude,
            'email' => $this->faker->unique()->companyEmail,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'manager_name' => $this->faker->name,
            'manager_email' => $this->faker->unique()->safeEmail,
            'manager_phone_number' => $this->faker->unique()->phoneNumber,
            'additional_info' => $this->faker->optional()->sentence,
            'store_code' => $this->faker->unique()->bothify('??-####'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
