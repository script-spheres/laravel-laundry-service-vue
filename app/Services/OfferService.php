<?php

namespace App\Services;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Spatie\QueryBuilder\QueryBuilder;

class OfferService
{
    /**
     * Get paginated offers with filters and sorting.
     */
    public function getOffers()
    {
        return QueryBuilder::for(Offer::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new offer.
     */
    public function create(StoreOfferRequest $request): Offer
    {
        $attributes = $request->validated();
        return Offer::create($attributes);
    }

    /**
     * Update an existing offer.
     */
    public function update(Offer $offer, UpdateOfferRequest $request): Offer
    {
        $attributes = $request->validated();
        $offer->update($attributes);
        return $offer;
    }

    /**
     * Delete an offer.
     */
    public function delete(Offer $offer): void
    {
        $offer->delete();
    }
}
