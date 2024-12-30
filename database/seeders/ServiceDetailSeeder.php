<?php

namespace Database\Seeders;

use App\Models\ServiceDetail;
use Illuminate\Database\Seeder;

class ServiceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        ServiceDetail::factory()->count(20)->create();
    }
}
