<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccessoryRequest;
use App\Http\Requests\UpdateAccessoryRequest;
use App\Http\Resources\AccessoryResource;
use App\Models\Accessory;
use App\Models\Unit;
use App\Services\AccessoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AccessoryService $accessoryService)
    {
        $accessories = $accessoryService->getAccessories();

        return Inertia::render('Admin/Accessory/AccessoryIndex', [
            'accessories' => AccessoryResource::collection($accessories),
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccessoryRequest $request, AccessoryService $accessoryService)
    {
        $accessoryService->create($request);

        return redirect()->route('admin.accessories.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Accessory/AccessoryForm', [
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Accessory $accessory)
    {
        return Inertia::render('Admin/Accessory/AccessoryForm', [
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
            'accessory' => AccessoryResource::make($accessory)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accessory $accessory)
    {
        return Inertia::render('Admin/Accessory/AccessoryForm', [
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
            'accessory' => AccessoryResource::make($accessory)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccessoryRequest $request, Accessory $accessory, AccessoryService $accessoryService)
    {
        $accessoryService->update($accessory, $request);

        return redirect()->route('admin.accessories.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accessory $accessory, AccessoryService $accessoryService)
    {
        $accessoryService->delete($accessory);

        return redirect()->route('admin.accessories.index')->with(['message' => 'Deleted successfully']);
    }
}
