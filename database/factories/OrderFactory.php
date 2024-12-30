<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Store;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_uuid' => $this->faker->uuid(),
            'order_display_id' => 'ORD-' . $this->faker->unique()->numerify('#####'),
            'customer_id' => Customer::factory(),
            'store_id' => Store::factory(),
            'total_weight_kg' => $this->faker->randomFloat(2, 1, 10),
            'sub_total' => $this->faker->randomFloat(2, 50, 500),
            'total_amount' => $this->faker->randomFloat(2, 50, 500),
            'tax_amount' => $this->faker->randomFloat(2, 5, 50),
            'discount_amount' => $this->faker->randomFloat(2, 0, 20),
            'paid_amount' => $this->faker->randomFloat(2, 0, 500),
            'delivery_date' => now()->addDays(5)->toDateString(),
            'quick_note' => $this->faker->sentence(),
            'order_status' => $this->faker->randomElement(['pending', 'in-progress', 'ready-to-deliver', 'delivered']),
        ];
    }
}
