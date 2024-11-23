<?php

namespace App\Services;

use App\Http\Requests\StoreDeliveryScaleRequest;
use App\Http\Requests\UpdateDeliveryScaleRequest;
use App\Models\DeliveryScale;
use Spatie\QueryBuilder\QueryBuilder;

class DeliveryScaleService
{
    /**
     * Get paginated delivery scales with filters and sorting.
     */
    public function getDeliveryScales()
    {
        return QueryBuilder::for(DeliveryScale::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new delivery scale.
     */
    public function create(StoreDeliveryScaleRequest $request): DeliveryScale
    {
        $attributes = $request->validated();
        return DeliveryScale::create($attributes);
    }

    /**
     * Update an existing delivery scale.
     */
    public function update(DeliveryScale $deliveryScale, UpdateDeliveryScaleRequest $request): DeliveryScale
    {
        $attributes = $request->validated();
        $deliveryScale->update($attributes);
        return $deliveryScale;
    }

    /**
     * Delete a delivery scale.
     */
    public function delete(DeliveryScale $deliveryScale): void
    {
        $deliveryScale->delete();
    }
}
