<?php

namespace App\Services;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Review;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReviewService
{
    /**
     * Get paginated reviews with filters and sorting.
     */
    public function getReviews()
    {
        return QueryBuilder::for(Review::class)
            ->with(['model', 'author'])
            ->allowedFilters([
                AllowedFilter::callback('order_display_id', function ($query, $value) {
                    $query->whereHas('model', function ($query) use ($value) {
                        $query->where('order_display_id', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('customer_name', function ($query, $value) {
                    $query->whereHas('author', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new review.
     */
    public function create(StoreReviewRequest $request): Review
    {
        // Adding default values for model_type and author_type if not provided
        $attributes = $request->validated();

        $attributes['model_type'] = $attributes['model_type'] ?? Order::class;
        $attributes['model_id'] = $attributes['order_id'];

        $attributes['author_type'] = $attributes['author_type'] ?? Customer::class;
        $attributes['author_id'] = $attributes['customer_id'];

        return Review::create($attributes);
    }

    /**
     * Update an existing review.
     */
    public function update(Review $review, UpdateReviewRequest $request): Review
    {
        // Adding default values for model_type and author_type if not provided
        $attributes = $request->validated();

        $attributes['model_type'] = $attributes['model_type'] ?? Order::class;
        $attributes['model_id'] = $attributes['order_id'];

        $attributes['author_type'] = $attributes['author_type'] ?? Customer::class;
        $attributes['author_id'] = $attributes['customer_id'];

        // Update the review attributes
        $review->update($attributes);

        return $review;
    }

    /**
     * Delete a review.
     */
    public function delete(Review $review): void
    {
        $review->delete();
    }
}
