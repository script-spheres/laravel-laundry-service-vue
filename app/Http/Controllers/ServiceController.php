<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ServiceTypeService $serviceTypeService)
    {
        $serviceTypes = $serviceTypeService->getServiceTypes();

        return Inertia::render('ServiceType/ServiceTypeIndex', [
            'services' => ServiceResource::collection($serviceTypes),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ServiceType/ServiceTypeForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->create($request);

        return redirect()->route('service-types.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $serviceType)
    {
        return Inertia::render('ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceResource::make($serviceType)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $serviceType)
    {
        return Inertia::render('ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceResource::make($serviceType)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $serviceType, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->update($serviceType, $request);

        return redirect()->route('service-types.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $serviceType, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->delete($serviceType);

        return redirect()->route('service-types.index')->with(['message' => 'Deleted successfully']);
    }
}
