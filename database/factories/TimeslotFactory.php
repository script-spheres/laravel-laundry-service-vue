<?php

namespace Database\Factories;

use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Timeslot>
 */
class TimeslotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_time = $this->faker->time('H:i:s');
        $end_time = $this->faker->time('H:i:s', '23:59:59');
        return [
            'day' => $this->faker->randomElement(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
