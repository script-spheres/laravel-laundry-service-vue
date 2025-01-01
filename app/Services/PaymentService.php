<?php

namespace App\Services;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentService
{
    /**
     * Get paginated payments with filters and sorting.
     */
    public function getPayments()
    {
        return QueryBuilder::for(Payment::class)
            ->with(['order', 'order.customer'])
            ->allowedFilters([
                AllowedFilter::callback('order_display_id', function ($query, $value) {
                    $query->whereHas('order', function ($query) use ($value) {
                        $query->where('order_display_id', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('customer_name', function ($query, $value) {
                    $query->whereHas('customer', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new payment.
     */
    public function create(StorePaymentRequest $request): Payment
    {
        // Adding default values for order and customer if not provided
        $attributes = $request->validated();

        $attributes['order_id'] = $attributes['order_id'] ?? null;
        $attributes['customer_id'] = $attributes['customer_id'] ?? null;

        return Payment::create($attributes);
    }

    /**
     * Update an existing payment.
     */
    public function update(Payment $payment, UpdatePaymentRequest $request): Payment
    {
        // Adding default values for order and customer if not provided
        $attributes = $request->validated();

        $attributes['order_id'] = $attributes['order_id'] ?? null;
        $attributes['customer_id'] = $attributes['customer_id'] ?? null;

        // Update the payment attributes
        $payment->update($attributes);

        return $payment;
    }

    /**
     * Delete a payment.
     */
    public function delete(Payment $payment): void
    {
        $payment->delete();
    }
}
