<?php

namespace App\Services;

use App\Http\Requests\StoreServiceItemRequest;
use App\Http\Requests\UpdateServiceItemRequest;
use App\Models\ServiceItem;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceItemService
{
    /**
     * Get paginated service items with filters and sorting.
     */
    public function getServiceItems()
    {
        return QueryBuilder::for(ServiceItem::class)
        ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service item.
     */
    public function create(StoreServiceItemRequest $request): ServiceItem
    {
        $attributes = $request->validated();
        return ServiceItem::create($attributes);
    }

    /**
     * Update an existing service item.
     */
    public function update(ServiceItem $serviceItem, UpdateServiceItemRequest $request): ServiceItem
    {
        $attributes = $request->validated();
        $serviceItem->update($attributes);
        return $serviceItem;
    }

    /**
     * Delete a service item.
     */
    public function delete(ServiceItem $serviceItem): void
    {
        $serviceItem->delete();
    }
}
