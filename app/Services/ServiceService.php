<?php

namespace App\Services;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceService
{
    /**
     * Get paginated services with filters and sorting.
     */
    public function getServices()
    {
        return QueryBuilder::for(Service::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service.
     */
    public function create(StoreServiceRequest $request): Service
    {
        $attributes = $request->validated();
        return Service::create($attributes);
    }

    /**
     * Update an existing service.
     */
    public function update(Service $service, UpdateServiceRequest $request): Service
    {
        $attributes = $request->validated();
        $service->update($attributes);
        return $service;
    }

    /**
     * Delete a service.
     */
    public function delete(Service $service): void
    {
        $service->delete();
    }
}
