<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ServiceItem;
use App\Models\ServiceDetail;
use App\Models\Service;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceDetail>
 */
class ServiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => $this->faker->randomElement(Category::pluck('id')->toArray()),
            'service_id' => $this->faker->randomElement(Service::pluck('id')->toArray()),
            'service_item_id' => $this->faker->randomElement(ServiceItem::pluck('id')->toArray()),
            'unit_id' => $this->faker->randomElement(Unit::pluck('id')->toArray()),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
