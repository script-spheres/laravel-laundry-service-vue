<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, UnitService $unitService)
    {
        $units = $unitService->getUnits();

        return Inertia::render('Unit/UnitIndex', [
            'units' => UnitResource::collection($units),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Unit/UnitForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request, UnitService $unitService)
    {
        $unitService->create($request);

        return redirect()->route('units.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return Inertia::render('Unit/UnitShow', [
            'unit' => UnitResource::make($unit)->resolve(),
            'permissions' => Inertia::defer(fn () => Permission::all()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return Inertia::render('Unit/UnitForm', [
            'unit' => UnitResource::make($unit)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit, UnitService $unitService)
    {
        $unitService->update($unit, $request);

        return redirect()->route('units.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit, UnitService $unitService)
    {
        $unitService->delete($unit);

        return redirect()->route('units.index')->with(['message' => 'Deleted successfully']);
    }
}