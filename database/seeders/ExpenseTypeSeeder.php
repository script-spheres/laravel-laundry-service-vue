<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseTypes = collect([
            'Utilities',
            'Rent',
            'Salaries',
            'Office Supplies',
            'Marketing',
            'Transportation',
            'Insurance',
            'Miscellaneous',
        ]);

        $expenseTypes->each(fn($name) => ExpenseType::create(['name' => $name]));
    }
}
