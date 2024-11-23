<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ServiceService $serviceService)
    {
        $services = $serviceService->getServices();

        return inertia('Admin/Service/ServiceIndex', [
            'services' => ServiceResource::collection($services),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Service/ServiceForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request, ServiceService $serviceService)
    {
        $serviceService->create($request);

        return redirect()->route('admin.services.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return inertia('Admin/Service/ServiceForm', [
            'service' => ServiceResource::make($service)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return inertia('Admin/Service/ServiceForm', [
            'service' => ServiceResource::make($service)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service, ServiceService $serviceService)
    {
        $serviceService->update($service, $request);

        return redirect()->route('admin.services.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceService $serviceService)
    {
        $serviceService->delete($service);

        return redirect()->route('admin.services.index')->with(['message' => 'Deleted successfully']);
    }
}
