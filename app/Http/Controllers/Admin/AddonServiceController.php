<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAddonServiceRequest;
use App\Http\Requests\Admin\UpdateAddonServiceRequest;
use App\Http\Resources\Admin\AddonServiceResource;
use App\Models\AddonService;
use App\Services\AddonServiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddonServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AddonServiceService $addonServiceService)
    {
        $addonServices = $addonServiceService->getAddonServices();

        return Inertia::render('Admin/AddonService/AddonServiceIndex', [
            'addonServices' => AddonServiceResource::collection($addonServices),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/AddonService/AddonServiceForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddonServiceRequest $request, AddonServiceService $addonServiceService)
    {
        $addonServiceService->create($request);

        return redirect()->route('admin.addonServices.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(AddonService $addonService)
    {
        return Inertia::render('Admin/AddonService/AddonServiceForm', [
            'addonService' => AddonServiceResource::make($addonService)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddonService $addonService)
    {
        return Inertia::render('Admin/AddonService/AddonServiceForm', [
            'addonService' => AddonServiceResource::make($addonService)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddonServiceRequest $request, AddonService $addonService, AddonServiceService $addonServiceService)
    {
        $addonServiceService->update($addonService, $request);

        return redirect()->route('admin.addonServices.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddonService $addonService, AddonServiceService $addonServiceService)
    {
        $addonServiceService->delete($addonService);

        return redirect()->route('admin.addonServices.index')->with(['message' => 'Deleted successfully']);
    }
}
