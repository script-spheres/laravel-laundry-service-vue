<?php

namespace App\Services;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Spatie\QueryBuilder\QueryBuilder;

class ExpenseService
{
    /**
     * Get paginated expenses with filters and sorting.
     */
    public function getExpenses()
    {
        return QueryBuilder::for(Expense::class)
            ->allowedFilters(['id', 'amount', 'description'])
            ->allowedSorts(['amount', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new expense.
     */
    public function create(StoreExpenseRequest $request): Expense
    {
        $attributes = $request->validated();
        return Expense::create($attributes);
    }

    /**
     * Update an existing expense.
     */
    public function update(Expense $expense, UpdateExpenseRequest $request): Expense
    {
        $attributes = $request->validated();
        $expense->update($attributes);
        return $expense;
    }

    /**
     * Delete an expense.
     */
    public function delete(Expense $expense): void
    {
        $expense->delete();
    }
}
