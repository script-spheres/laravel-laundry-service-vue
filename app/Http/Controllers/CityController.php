<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CityService $cityService): Response
    {
        $cities = $cityService->getCities();

        return Inertia::render('City/CityIndex', [
            'cities' => CityResource::collection($cities),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request, CityService $cityService): RedirectResponse
    {
        $cityService->create($request);

        return redirect()->route('cities.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('City/CityForm');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city): Response
    {
        return Inertia::render('City/CityForm', [
            'city' => CityResource::make($city)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): Response
    {
        return Inertia::render('City/CityForm', [
            'city' => CityResource::make($city)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city, CityService $cityService): RedirectResponse
    {
        $cityService->update($city, $request);

        return redirect()->route('cities.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city, CityService $cityService): RedirectResponse
    {
        $cityService->delete($city);

        return redirect()->route('cities.index')->with(['message' => 'Deleted successfully']);
    }
}
