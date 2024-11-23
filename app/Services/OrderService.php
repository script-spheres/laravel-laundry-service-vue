<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Spatie\QueryBuilder\QueryBuilder;

class OrderService
{
    /**
     * Get paginated orders with filters and sorting.
     */
    public function getOrders()
    {
        return QueryBuilder::for(Order::class)
            ->allowedFilters(['id', 'customer_id', 'status'])
            ->allowedSorts(['created_at', 'status'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new order.
     */
    public function create(StoreOrderRequest $request): Order
    {
        $attributes = $request->validated();
        return Order::create($attributes);
    }

    /**
     * Update an existing order.
     */
    public function update(Order $order, UpdateOrderRequest $request): Order
    {
        $attributes = $request->validated();
        $order->update($attributes);
        return $order;
    }

    /**
     * Delete an order.
     */
    public function delete(Order $order): void
    {
        $order->delete();
    }
}
