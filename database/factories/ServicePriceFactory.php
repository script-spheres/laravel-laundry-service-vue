<?php

namespace Database\Factories;

use App\Models\ServiceItem;
use App\Models\ServicePrice;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServicePrice>
 */
class ServicePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_item_id' => ServiceItem::factory(),
            'service_type_id' => ServiceType::factory(),
            'price' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
