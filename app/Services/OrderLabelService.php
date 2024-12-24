<?php

namespace App\Services;

use App\Http\Requests\StoreOrderLabelRequest;
use App\Http\Requests\UpdateOrderLabelRequest;
use App\Models\OrderLabel;
use Spatie\QueryBuilder\QueryBuilder;

class OrderLabelService
{
    /**
     * Get paginated order labels with filters and sorting.
     */
    public function getOrderLabels()
    {
        return QueryBuilder::for(OrderLabel::class)
            ->allowedFilters(['name', 'status'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new order label.
     */
    public function create(StoreOrderLabelRequest $request): OrderLabel
    {
        $attributes = $request->validated();
        return OrderLabel::create($attributes);
    }

    /**
     * Update an existing order label.
     */
    public function update(OrderLabel $orderLabel, UpdateOrderLabelRequest $request): OrderLabel
    {
        $attributes = $request->validated();
        $orderLabel->update($attributes);
        return $orderLabel;
    }

    /**
     * Delete an order label.
     */
    public function delete(OrderLabel $orderLabel): void
    {
        $orderLabel->delete();
    }
}
