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
            [
                'day' => 'sunday',
                'timeslots' => json_encode([
                    ['start' => '08:00', 'end' => '10:00'],
                    ['start' => '12:00', 'end' => '14:00'],
                ]),
                'status' => 'active',
            ],
            [
                'day' => 'monday',
                'timeslots' => json_encode([
                    ['start' => '09:00', 'end' => '11:00'],
                    ['start' => '13:00', 'end' => '15:00'],
                ]),
                'status' => 'inactive',
            ],
            [
                'day' => 'tuesday',
                'timeslots' => json_encode([
                    ['start' => '10:00', 'end' => '12:00'],
                    ['start' => '14:00', 'end' => '16:00'],
                ]),
                'status' => 'active',
            ],
            [
                'day' => 'wednesday',
                'timeslots' => json_encode([
                    ['start' => '08:00', 'end' => '10:00'],
                    ['start' => '12:00', 'end' => '14:00'],
                ]),
                'status' => 'inactive',
            ],
            [
                'day' => 'thursday',
                'timeslots' => json_encode([
                    ['start' => '09:00', 'end' => '11:00'],
                    ['start' => '13:00', 'end' => '15:00'],
                ]),
                'status' => 'active',
            ],
            [
                'day' => 'friday',
                'timeslots' => json_encode([
                    ['start' => '10:00', 'end' => '12:00'],
                    ['start' => '14:00', 'end' => '16:00'],
                ]),
                'status' => 'inactive',
            ],
            [
                'day' => 'saturday',
                'timeslots' => json_encode([
                    ['start' => '11:00', 'end' => '13:00'],
                    ['start' => '15:00', 'end' => '17:00'],
                ]),
                'status' => 'active',
            ],
        ]);

        // Create each timeslot record
        $timeslots->each(fn($slot) => Timeslot::create($slot));
    }
}
