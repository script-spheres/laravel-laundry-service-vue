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
            ['name' => 'Utilities', 'description' => 'Expenses related to electricity, water, gas, and other utilities.'],
            ['name' => 'Rent', 'description' => 'Monthly rent paid for office space or property.'],
            ['name' => 'Salaries', 'description' => 'Employee wages and salaries for the business.'],
            ['name' => 'Office Supplies', 'description' => 'Expenses for office stationery, computers, and other office supplies.'],
            ['name' => 'Marketing', 'description' => 'Costs related to advertising, promotions, and marketing campaigns.'],
            ['name' => 'Transportation', 'description' => 'Expenses for transportation, including fuel, vehicle maintenance, and public transport.'],
            ['name' => 'Insurance', 'description' => 'Premiums for various insurance policies, including health, property, and liability insurance.'],
            ['name' => 'Miscellaneous', 'description' => 'Other unclassified or varied expenses that don\'t fall into the above categories.'],
        ]);

        $expenseTypes->each(fn($expenseType) => ExpenseType::create($expenseType));
    }
}
