<?php

namespace App\Services;

use App\Http\Requests\StoreExpenseTypeRequest;
use App\Http\Requests\UpdateExpenseTypeRequest;
use App\Models\ExpenseType;
use Spatie\QueryBuilder\QueryBuilder;

class ExpenseTypeService
{
    /**
     * Get paginated expense types with filters and sorting.
     */
    public function getExpenseTypes()
    {
        return QueryBuilder::for(ExpenseType::class)
            ->allowedFilters(['id', 'name', 'status'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new expense type.
     */
    public function create(StoreExpenseTypeRequest $request): ExpenseType
    {
        $attributes = $request->validated();
        return ExpenseType::create($attributes);
    }

    /**
     * Update an existing expense type.
     */
    public function update(ExpenseType $expenseType, UpdateExpenseTypeRequest $request): ExpenseType
    {
        $attributes = $request->validated();
        $expenseType->update($attributes);
        return $expenseType;
    }

    /**
     * Delete an expense type.
     */
    public function delete(ExpenseType $expenseType): void
    {
        $expenseType->delete();
    }
}
