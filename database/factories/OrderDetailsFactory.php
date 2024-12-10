<?php

namespace Database\Factories;

use App\Models\AddonService;
use App\Models\Order;
use App\Models\ServiceDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'serviceable_type' => $this->faker->randomElement([AddonService::class, ServiceDetail::class]),
            'serviceable_id' => function (array $attributes) {
                if ($attributes['serviceable_type'] === AddonService::class) {
                    return AddonService::factory()->create()->id;
                } else {
                    return ServiceDetail::factory()->create()->id;
                }
            },
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
