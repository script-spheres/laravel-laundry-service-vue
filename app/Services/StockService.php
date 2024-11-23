<?php

namespace App\Services;

use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Stock;
use Spatie\QueryBuilder\QueryBuilder;

class StockService
{
    /**
     * Get paginated stock items with filters and sorting.
     */
    public function getStocks()
    {
        return QueryBuilder::for(Stock::class)
            ->allowedFilters(['id', 'product_id', 'quantity'])
            ->allowedSorts(['product_id', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new stock item.
     */
    public function create(StoreStockRequest $request): Stock
    {
        $attributes = $request->validated();
        return Stock::create($attributes);
    }

    /**
     * Update an existing stock item.
     */
    public function update(Stock $stock, UpdateStockRequest $request): Stock
    {
        $attributes = $request->validated();
        $stock->update($attributes);
        return $stock;
    }

    /**
     * Delete a stock item.
     */
    public function delete(Stock $stock): void
    {
        $stock->delete();
    }
}
