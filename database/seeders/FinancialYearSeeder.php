<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $financialYears = [
            [
                'name' => '2023-2024 Financial Year',
                'start_date' => '2023-04-01',
                'end_date' => '2024-03-31',
            ],
            [
                'name' => '2024-2025 Financial Year',
                'start_date' => '2024-04-01',
                'end_date' => '2025-03-31',
            ],
            [
                'name' => '2025-2026 Financial Year',
                'start_date' => '2025-04-01',
                'end_date' => '2026-03-31',
            ],
        ];

        foreach ($financialYears as $data) {
            FinancialYear::factory()->create($data);
        }
    }
}
