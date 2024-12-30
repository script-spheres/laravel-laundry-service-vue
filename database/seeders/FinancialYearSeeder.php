<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the current year and the next year
        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;

        $financialYears = collect([
            [
                'name' => "{$currentYear}-{$nextYear} Financial Year",
                'start_date' => "{$currentYear}-04-01",
                'end_date' => "{$nextYear}-03-31",
            ],
            [
                'name' => "{$nextYear}-" . ($nextYear + 1) . " Financial Year",
                'start_date' => "{$nextYear}-04-01",
                'end_date' => ($nextYear + 1) . "-03-31",
            ],
            [
                'name' => ($nextYear + 1) . '-' . ($nextYear + 2) . ' Financial Year',
                'start_date' => ($nextYear + 1) . '-04-01',
                'end_date' => ($nextYear + 2) . '-03-31',
            ],
        ]);

        $financialYears->each(fn($data) => FinancialYear::create($data));
    }
}
