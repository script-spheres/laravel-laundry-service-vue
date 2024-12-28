<?php

namespace App\Services;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
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
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('service_id'),
                AllowedFilter::exact('rating'),
                AllowedFilter::partial('comment'),
            ])
            ->allowedSorts(['created_at', 'rating'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new review.
     */
    public function create(StoreReviewRequest $request): Review
    {
        $attributes = $request->validated();

        return Review::create($attributes);
    }

    /**
     * Update an existing review.
     */
    public function update(Review $review, UpdateReviewRequest $request): Review
    {
        $attributes = $request->validated();

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
