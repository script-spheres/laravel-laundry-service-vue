<?php

namespace App\Services;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceTypeService
{
    /**
     * Get paginated service types with filters and sorting.
     */
    public function getServiceTypes()
    {
        return QueryBuilder::for(Service::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service type.
     */
    public function create(StoreServiceRequest $request): Service
    {
        $attributes = $request->validated();
        return Service::create($attributes);
    }

    /**
     * Update an existing service type.
     */
    public function update(Service $serviceType, UpdateServiceRequest $request): Service
    {
        $attributes = $request->validated();
        $serviceType->update($attributes);
        return $serviceType;
    }

    /**
     * Delete a service type.
     */
    public function delete(Service $serviceType): void
    {
        $serviceType->delete();
    }
}
