<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddonServiceRequest;
use App\Http\Requests\UpdateAddonServiceRequest;
use App\Http\Resources\AddonServiceResource;
use App\Models\AddonService;
use App\Services\AddonServiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddonServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AddonServiceService $addonServiceService): \Inertia\Response
    {
        $addonServices = $addonServiceService->getAddonServices();

        return Inertia::render('AddonService/AddonServiceIndex', [
            'addonServices' => AddonServiceResource::collection($addonServices),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('AddonService/AddonServiceForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddonServiceRequest $request, AddonServiceService $addonServiceService): \Illuminate\Http\RedirectResponse
    {
        $addonServiceService->create($request);

        return redirect()->route('addon-services.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(AddonService $addonService): \Inertia\Response
    {
        return Inertia::render('AddonService/AddonServiceForm', [
            'addonService' => AddonServiceResource::make($addonService)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddonService $addonService): \Inertia\Response
    {
        return Inertia::render('AddonService/AddonServiceForm', [
            'addonService' => AddonServiceResource::make($addonService)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddonServiceRequest $request, AddonService $addonService, AddonServiceService $addonServiceService): \Illuminate\Http\RedirectResponse
    {
        $addonServiceService->update($addonService, $request);

        return redirect()->route('addon-services.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddonService $addonService, AddonServiceService $addonServiceService): \Illuminate\Http\RedirectResponse
    {
        $addonServiceService->delete($addonService);

        return redirect()->route('addon-services.index')->with(['message' => 'Deleted successfully']);
    }
}
