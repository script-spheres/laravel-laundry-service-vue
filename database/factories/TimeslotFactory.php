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

            // Generate an array of multiple timeslots
            'timeslots' => json_encode($this->generateRandomTimeslots()),

            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Generate random timeslots where end_time is always after start_time.
     *
     * @return array
     */
    private function generateRandomTimeslots(): array
    {
        $timeslotsCount = rand(1, 5);
        $timeslots = [];

        for ($i = 0; $i < $timeslotsCount; $i++) {
            $startTime = $this->faker->time();
            $endTime = $this->generateEndTimeAfterStart($startTime);

            $timeslots[] = [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        }

        return $timeslots;
    }

    /**
     * Generate a random time gap between start and end times.
     *
     * @return int
     */
    private function timeGap(): int
    {
        // Returns a random gap in minutes (between 30 minutes and 2 hours)
        return rand(30, 120);
    }

    /**
     * Ensure that the end_time is after the start_time by the generated time gap.
     *
     * @param string $startTime
     * @return string
     */
    private function generateEndTimeAfterStart(string $startTime): string
    {
        // Convert start time to minutes for comparison
        $startMinutes = strtotime($startTime) / 60;

        // Get the time gap in minutes
        $gap = $this->timeGap();

        // Add the gap to the start time
        $endMinutes = $startMinutes + $gap;

        // Convert end time back to time format
        return date("H:i:s", $endMinutes * 60);
    }
}
