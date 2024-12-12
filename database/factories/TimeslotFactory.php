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
        return [
            'day' => $this->faker->randomElement(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']),
            'timeslots' => json_encode([
                ['start' => '09:00', 'end' => '11:00'],
                ['start' => '13:00', 'end' => '15:00'],
                ['start' => '17:00', 'end' => '19:00'],
            ]),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
