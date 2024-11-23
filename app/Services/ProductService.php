<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService
{
    /**
     * Get paginated products with filters and sorting.
     */
    public function getProducts()
    {
        return QueryBuilder::for(Product::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new product.
     */
    public function create(StoreProductRequest $request): Product
    {
        $attributes = $request->validated();
        return Product::create($attributes);
    }

    /**
     * Update an existing product.
     */
    public function update(Product $product, UpdateProductRequest $request): Product
    {
        $attributes = $request->validated();
        $product->update($attributes);
        return $product;
    }

    /**
     * Delete a product.
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }
}
