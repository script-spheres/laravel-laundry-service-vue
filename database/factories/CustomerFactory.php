<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->address,
            'communication_pref' => json_encode([
                'email' => $this->faker->boolean,
                'sms' => $this->faker->boolean,
                'push_notification' => $this->faker->boolean
            ]),
            'referral_code' => strtoupper(Str::random(10)),
            'referral_count' => $this->faker->numberBetween(0, 10),
            'referred_by' => null,
        ];
    }


    /**
     * Indicate that the user has a referral.
     *
     * @return CustomerFactory
     */
    public function withReferral():static
    {
        return $this->state(fn (array $attributes) => [
            'referred_by' => Customer::factory(),
        ]);
    }
}
