<?php

namespace App\Services;

use App\Http\Controllers\AddonServiceController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\AddonService;
use App\Models\Order;
use App\Models\OrderLabel;
use App\Models\ServiceDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderService
{
    /**
     * Get paginated orders with filters and sorting.
     */
    public function getOrders()
    {
        return QueryBuilder::for(Order::class)
            ->allowedFilters([
                AllowedFilter::exact('order_display_id'),
                AllowedFilter::exact('customer_name'),
                AllowedFilter::exact('order_status'),
                AllowedFilter::exact('payment_status'),
                AllowedFilter::callback('customer', function ($query, $value) {
                    $query->whereHas('customer', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('store', function ($query, $value) {
                    $query->whereHas('store', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('orderLabel', function ($query, $value) {
                    $query->whereHas('orderLabel', function ($query) use ($value) {
                        $query->where('label', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['created_at', 'status'])
            ->with(['customer', 'store', 'orderLabel'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new order.
     */
    public function create(StoreOrderRequest $request): Order
    {
        $attributes = $request->validated();

        // Generate a unique UUID for the order
        $attributes['order_uuid'] = Str::uuid()->toString();
        $attributes['order_display_id'] = $this->generateOrderDisplayId();
        $attributes['order_label_id'] = $this->generateOrderLabelId();
        $attributes['delivery_date'] = $attributes['delivery_date'] ?? Carbon::now()->addDays(5);

        // Create the order in the database
        $order = Order::create($attributes);

        // Add the associated order details (items, etc.)
        if ($request->has('details') && is_array($request->details)) {
            foreach ($request->details as $detail) {
                // Validate the detail (you can add validation here if needed)
                if (!isset($detail['serviceable_type'])) {
                    continue; // Skip if no serviceable_type is present
                }

                // Handle serviceable_type mapping correctly
                if ($detail['serviceable_type'] === 'service') {
                    $detail['serviceable_type'] = ServiceDetail::class;
                }
                if ($detail['serviceable_type'] === 'addon-service') {
                    $detail['serviceable_type'] = AddonService::class;
                }

                // Ensure the necessary fields are in the $detail array
                $order->orderDetails()->create($detail);
            }
        }

        return $order;
    }


    /**
     * Generate a unique order display ID.
     * This method can be customized as per your needs.
     */
    private function generateOrderDisplayId(): string
    {
        // Example: Generate a display ID based on the latest order ID or a sequence
        $latestOrder = Order::latest()->first();
        $latestId = $latestOrder ? $latestOrder->id : 0;

        // Increment the latest order ID to generate the next display ID
        return 'ORD-' . str_pad($latestId + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a unique order label ID.
     * This method can be customized as per your needs.
     */
    private function generateOrderLabelId(): string
    {
        $orderLabel = OrderLabel::where('name', 'pending')->first();

        return $orderLabel->id;
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
