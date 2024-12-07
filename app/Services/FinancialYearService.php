<?php

namespace App\Services;

use App\Http\Requests\StoreFinancialYearRequest;
use App\Http\Requests\UpdateFinancialYearRequest;
use App\Models\FinancialYear;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FinancialYearService
{
    /**
     * Get paginated financial years with filters and sorting.
     */
    public function getFinancialYears()
    {
        return QueryBuilder::for(FinancialYear::class)
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::partial('start_date'),
                AllowedFilter::partial('end_date'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts(['title', 'created_at'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new financial year.
     */
    public function create(StoreFinancialYearRequest $request): FinancialYear
    {
        $attributes = $request->validated();

        return FinancialYear::create($attributes);
    }

    /**
     * Update an existing financial year.
     */
    public function update(FinancialYear $financialYear, UpdateFinancialYearRequest $request): FinancialYear
    {
        $attributes = $request->validated();

        // Update the financial year attributes
        $financialYear->update($attributes);

        return $financialYear;
    }

    /**
     * Delete a financial year.
     */
    public function delete(FinancialYear $financialYear): void
    {
        $financialYear->delete();
    }
}
