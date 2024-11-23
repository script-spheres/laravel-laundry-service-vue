<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreServiceTypeRequest;
use App\Http\Requests\Admin\UpdateServiceTypeRequest;
use App\Models\ServiceType;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceTypeService
{
    /**
     * Get paginated service types with filters and sorting.
     */
    public function getServiceTypes()
    {
        return QueryBuilder::for(ServiceType::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service type.
     */
    public function create(StoreServiceTypeRequest $request): ServiceType
    {
        $attributes = $request->validated();
        return ServiceType::create($attributes);
    }

    /**
     * Update an existing service type.
     */
    public function update(ServiceType $serviceType, UpdateServiceTypeRequest $request): ServiceType
    {
        $attributes = $request->validated();
        $serviceType->update($attributes);
        return $serviceType;
    }

    /**
     * Delete a service type.
     */
    public function delete(ServiceType $serviceType): void
    {
        $serviceType->delete();
    }
}
