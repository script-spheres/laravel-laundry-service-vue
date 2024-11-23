<?php

namespace App\Services;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierService
{
    /**
     * Get paginated suppliers with filters and sorting.
     */
    public function getSuppliers()
    {
        return QueryBuilder::for(Supplier::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new supplier.
     */
    public function create(StoreSupplierRequest $request): Supplier
    {
        $attributes = $request->validated();
        return Supplier::create($attributes);
    }

    /**
     * Update an existing supplier.
     */
    public function update(Supplier $supplier, UpdateSupplierRequest $request): Supplier
    {
        $attributes = $request->validated();
        $supplier->update($attributes);
        return $supplier;
    }

    /**
     * Delete a supplier.
     */
    public function delete(Supplier $supplier): void
    {
        $supplier->delete();
    }
}
