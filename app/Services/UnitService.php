<?php

namespace App\Services;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Spatie\QueryBuilder\QueryBuilder;

class UnitService
{
    /**
     * Get paginated units with filters and sorting.
     */
    public function getUnits()
    {
        return QueryBuilder::for(Unit::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new unit.
     */
    public function create(StoreUnitRequest $request): Unit
    {
        $attributes = $request->validated();
        return Unit::create($attributes);
    }

    /**
     * Update an existing unit.
     */
    public function update(Unit $unit, UpdateUnitRequest $request): Unit
    {
        $attributes = $request->validated();
        $unit->update($attributes);
        return $unit;
    }

    /**
     * Delete a unit.
     */
    public function delete(Unit $unit): void
    {
        $unit->delete();
    }
}
