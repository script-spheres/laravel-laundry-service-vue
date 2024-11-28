<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Http\Requests\UpdateServiceTypeRequest;
use App\Http\Resources\ServiceTypeResource;
use App\Models\ServiceType;
use App\Services\ServiceTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ServiceTypeService $serviceTypeService)
    {
        $serviceTypes = $serviceTypeService->getServiceTypes();

        return Inertia::render('Admin/ServiceType/ServiceTypeIndex', [
            'serviceTypes' => ServiceTypeResource::collection($serviceTypes),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ServiceType/ServiceTypeForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceTypeRequest $request, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->create($request);

        return redirect()->route('admin.service-types.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceType $serviceType)
    {
        return Inertia::render('Admin/ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceTypeResource::make($serviceType)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceType $serviceType)
    {
        return Inertia::render('Admin/ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceTypeResource::make($serviceType)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->update($serviceType, $request);

        return redirect()->route('admin.service-types.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType, ServiceTypeService $serviceTypeService)
    {
        $serviceTypeService->delete($serviceType);

        return redirect()->route('admin.service-types.index')->with(['message' => 'Deleted successfully']);
    }
}
