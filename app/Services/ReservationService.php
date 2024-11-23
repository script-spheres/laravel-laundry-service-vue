<?php

namespace App\Services;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationService
{
    /**
     * Get paginated reservations with filters and sorting.
     */
    public function getReservations()
    {
        return QueryBuilder::for(Reservation::class)
            ->with(['outlet','table'])
            ->allowedFilters(['id', 'customer_id', 'table_id'])
            ->allowedSorts(['date', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new reservation.
     */
    public function create(StoreReservationRequest $request): Reservation
    {
        $attributes = $request->validated();
        return Reservation::create($attributes);
    }

    /**
     * Update an existing reservation.
     */
    public function update(Reservation $reservation, UpdateReservationRequest $request): Reservation
    {
        $attributes = $request->validated();
        $reservation->update($attributes);
        return $reservation;
    }

    /**
     * Delete a reservation.
     */
    public function delete(Reservation $reservation): void
    {
        $reservation->delete();
    }
}
