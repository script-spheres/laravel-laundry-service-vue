<?php

namespace App\Services;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StoreService
{
    /**
     * Get paginated stores with filters and sorting.
     */
    public function getStores()
    {
        return QueryBuilder::for(Store::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('name'),
                AllowedFilter::exact('address'),
                AllowedFilter::exact('email'),
                AllowedFilter::exact('phone_number'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new store.
     */
    public function create(StoreStoreRequest $request): Store
    {
        $attributes = $request->validated();

        return Store::create($attributes);
    }

    /**
     * Update an existing store.
     */
    public function update(Store $store, UpdateStoreRequest $request): Store
    {
        $attributes = $request->validated();

        $store->update($attributes);

        return $store;
    }

    /**
     * Delete a store.
     */
    public function delete(Store $store): void
    {
        $store->delete();
    }
}
