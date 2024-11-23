<?php

namespace App\Services;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseService
{
    /**
     * Get paginated purchases with filters and sorting.
     */
    public function getPurchases()
    {
        return QueryBuilder::for(Purchase::class)
            ->allowedFilters(['id', 'supplier_id'])
            ->allowedSorts(['created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new purchase.
     */
    public function create(StorePurchaseRequest $request): Purchase
    {
        $attributes = $request->validated();
        return Purchase::create($attributes);
    }

    /**
     * Update an existing purchase.
     */
    public function update(Purchase $purchase, UpdatePurchaseRequest $request): Purchase
    {
        $attributes = $request->validated();
        $purchase->update($attributes);
        return $purchase;
    }

    /**
     * Delete a purchase.
     */
    public function delete(Purchase $purchase): void
    {
        $purchase->delete();
    }
}
