<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceDetailRequest;
use App\Http\Requests\UpdateServiceDetailRequest;
use App\Http\Resources\ServiceDetailResource;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceItem;
use App\Models\Unit;
use App\Services\ServiceDetailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ServiceDetailService $serviceDetailService): Response
    {
        $serviceDetails = $serviceDetailService->getServiceDetails();

        return Inertia::render('ServiceDetail/ServiceDetailIndex', [
            'serviceDetails' => ServiceDetailResource::collection($serviceDetails),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceDetailRequest $request, ServiceDetailService $serviceDetailService): RedirectResponse
    {
        $serviceDetailService->create($request);

        return redirect()->route('service-details.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('ServiceDetail/ServiceDetailForm', [
            'serviceOptions' => Service::pluck('name', 'id'),
            'serviceItemOptions' => ServiceItem::pluck('name', 'id'),
            'categoryOptions' => Category::pluck('name', 'id'),
            'unitOptions' => Unit::pluck('short_name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceDetail $serviceDetail): Response
    {
        return Inertia::render('ServiceDetail/ServiceDetailForm', [
            'serviceDetail' => ServiceDetailResource::make($serviceDetail)->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceDetail $serviceDetail): Response
    {
        return Inertia::render('ServiceDetail/ServiceDetailForm', [
            'serviceDetail' => ServiceDetailResource::make($serviceDetail->load(['serviceItem','service','category','unit']))->resolve(),
            'serviceOptions' => Service::pluck('name', 'id'),
            'serviceItemOptions' => ServiceItem::pluck('name', 'id'),
            'categoryOptions' => Category::pluck('name', 'id'),
            'unitOptions' => Unit::pluck('short_name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceDetailRequest $request, ServiceDetail $serviceDetail, ServiceDetailService $serviceDetailService): RedirectResponse
    {
        $serviceDetailService->update($serviceDetail, $request);

        return redirect()->route('service-details.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceDetail $serviceDetail, ServiceDetailService $serviceDetailService): RedirectResponse
    {
        $serviceDetailService->delete($serviceDetail);

        return redirect()->route('service-details.index')->with(['message' => 'Deleted successfully']);
    }
}
