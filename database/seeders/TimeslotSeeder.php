<?php

namespace Database\Seeders;

use App\Models\Timeslot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define predefined timeslot data for all days of the week
        $timeslots = collect([
            ['day' => 'sunday', 'timeslots' => [['start_time' => '08:00', 'end_time' => '10:00'], ['start_time' => '12:00', 'end_time' => '14:00']], 'status' => 'active'],
            ['day' => 'monday', 'timeslots' => [['start_time' => '09:00', 'end_time' => '11:00'], ['start_time' => '13:00', 'end_time' => '15:00']], 'status' => 'inactive'],
            ['day' => 'tuesday', 'timeslots' => [['start_time' => '10:00', 'end_time' => '12:00'], ['start_time' => '14:00', 'end_time' => '16:00']], 'status' => 'active'],
            ['day' => 'wednesday', 'timeslots' => [['start_time' => '08:00', 'end_time' => '10:00'], ['start_time' => '12:00', 'end_time' => '14:00']], 'status' => 'inactive'],
            ['day' => 'thursday', 'timeslots' => [['start_time' => '09:00', 'end_time' => '11:00'], ['start_time' => '13:00', 'end_time' => '15:00']], 'status' => 'active'],
            ['day' => 'friday', 'timeslots' => [['start_time' => '10:00', 'end_time' => '12:00'], ['start_time' => '14:00', 'end_time' => '16:00']], 'status' => 'inactive'],
            ['day' => 'saturday', 'timeslots' => [['start_time' => '11:00', 'end_time' => '13:00'], ['start_time' => '15:00', 'end_time' => '17:00']], 'status' => 'active'],
        ]);

        // Create each timeslot record
        $timeslots->each(function ($slot) {
            // Iterate over each timeslot for the day
            collect($slot['timeslots'])->each(function ($timeslot) use ($slot) {
                Timeslot::create([
                    'day' => $slot['day'],
                    'start_time' => $timeslot['start_time'],
                    'end_time' => $timeslot['end_time'],
                    'status' => $slot['status'],
                ]);
            });
        });
    }
}
