<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreTimeslotRequest;
use App\Http\Requests\Admin\UpdateTimeslotRequest;
use App\Models\Timeslot;
use Spatie\QueryBuilder\QueryBuilder;

class TimeslotService
{
    /**
     * Get paginated timeslots with filters and sorting.
     */
    public function getTimeslots()
    {
        return QueryBuilder::for(Timeslot::class)
            ->allowedFilters(['id', 'start_time', 'end_time'])
            ->allowedSorts(['start_time', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new timeslot.
     */
    public function create(StoreTimeslotRequest $request): Timeslot
    {
        $attributes = $request->validated();
        return Timeslot::create($attributes);
    }

    /**
     * Update an existing timeslot.
     */
    public function update(Timeslot $timeslot, UpdateTimeslotRequest $request): Timeslot
    {
        $attributes = $request->validated();
        $timeslot->update($attributes);
        return $timeslot;
    }

    /**
     * Delete a timeslot.
     */
    public function delete(Timeslot $timeslot): void
    {
        $timeslot->delete();
    }
}
