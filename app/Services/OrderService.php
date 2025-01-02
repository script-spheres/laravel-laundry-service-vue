<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\AddonService;
use App\Models\Order;
use App\Models\OrderDetails;
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
        $attributes['order_uuid'] = Str::uuid()->toString();
        $attributes['order_display_id'] = $this->generateOrderDisplayId();
        $attributes['order_label_id'] = $this->generateOrderLabelId();
        $attributes['delivery_date'] = $attributes['delivery_date'] ?? Carbon::now()->addDays(5);

        $order = Order::create($attributes);

        // Create OrderDetails for the new order
        $this->syncOrderDetails($order, $request->details);

        return $order;
    }

    /**
     * Generate a unique order display ID.
     */
    private function generateOrderDisplayId(): string
    {
        $latestOrder = Order::latest()->first();
        $latestId = $latestOrder ? $latestOrder->id : 0;
        return 'ORD-' . str_pad($latestId + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a unique order label ID.
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

        // Update main order attributes
        $order->update($attributes);

        // Synchronize OrderDetails (delete missing, update or create new)
        $this->syncOrderDetails($order, $request->details);

        return $order;
    }

    /**
     * Sync OrderDetails by adding, updating, or deleting as needed.
     */
    private function syncOrderDetails(Order $order, array $details): void
    {
        // Key existing details by serviceable_id and serviceable_type
        $existingDetails = $order->orderDetails->keyBy(function ($detail) {
            return $detail->serviceable_id . '-' . $detail->serviceable_type;
        });

        // Key incoming details from request in the same way
        $updatedDetails = collect($details)->keyBy(function ($detail) {
            return $detail['serviceable_id'] . '-' . $detail['serviceable_type'];
        });

        // Delete OrderDetails not present in the updated request
        foreach ($existingDetails as $existingDetail) {
            $key = $existingDetail->serviceable_id . '-' . $existingDetail->serviceable_type;
            if (!isset($updatedDetails[$key])) {
                $existingDetail->delete();
            }
        }

        // Add or update OrderDetails
        foreach ($details as $detail) {
            $serviceableType = $this->getServiceableType($detail['serviceable_type']);

            // Check if detail exists, based on order ID and serviceable type
            $orderDetail = OrderDetails::where('order_id', $order->id)
                ->where('serviceable_id', $detail['serviceable_id'])
                ->where('serviceable_type', $serviceableType)
                ->first();

            // If order detail exists, update it
            if ($orderDetail) {
                $orderDetail->update([
                    'service_name' => $detail['service_name'],
                    'service_image' => $detail['service_image'],
                    'color' => $detail['color'],
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                    'total' => $detail['price'] * $detail['quantity'],
                ]);
            } else {
                // If order detail does not exist, create it
                OrderDetails::create([
                    'order_id' => $order->id,
                    'serviceable_type' => $serviceableType,
                    'serviceable_id' => $detail['serviceable_id'],
                    'service_name' => $detail['service_name'],
                    'service_image' => $detail['service_image'],
                    'color' => $detail['color'],
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                    'total' => $detail['price'] * $detail['quantity'],
                ]);
            }
        }
    }

    /**
     * Get serviceable type class name based on the provided type.
     */
    private function getServiceableType(string $serviceableType): string
    {
        return match ($serviceableType) {
            'service' => ServiceDetail::class,
            'addon-service' => AddonService::class,
            default => throw new \InvalidArgumentException("Invalid serviceable type: {$serviceableType}"),
        };
    }

    /**
     * Delete an order.
     */
    public function delete(Order $order): void
    {
        $order->delete();
    }
}
