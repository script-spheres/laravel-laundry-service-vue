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
        Timeslot::factory(10)->create();
    }
}
