<?php

namespace App\Services;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Spatie\QueryBuilder\QueryBuilder;

class CityService
{
    /**
     * Get paginated cities with filters and sorting.
     */
    public function getCities()
    {
        return QueryBuilder::for(City::class)
            ->allowedFilters(['id', 'name', 'status'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new city.
     */
    public function create(StoreCityRequest $request): City
    {
        $attributes = $request->validated();
        return City::create($attributes);
    }

    /**
     * Update an existing city.
     */
    public function update(City $city, UpdateCityRequest $request): City
    {
        $attributes = $request->validated();
        $city->update($attributes);
        return $city;
    }

    /**
     * Delete a city.
     */
    public function delete(City $city): void
    {
        $city->delete();
    }
}
