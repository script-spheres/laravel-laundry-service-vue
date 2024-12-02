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
            'customer_id' => Customer::factory(),
            'store_id' => Store::factory(),
            'total_weight_kg' => $this->faker->randomFloat(2, 1, 20),
            'total_price' => $this->faker->randomFloat(2, 10, 200),
            'tax' => $this->faker->randomFloat(2, 1, 10),
            'discount' => $this->faker->randomFloat(2, 1, 50),
            'paid_amount' => $this->faker->randomFloat(2, 1, 50),
            'delivery_date' => $this->faker->date(),
            'quick_note' => $this->faker->text,
            'order_status' => $this->faker->randomElement(['pending', 'in-progress', 'ready-to-deliver', 'delivered']),
        ];
    }
}
