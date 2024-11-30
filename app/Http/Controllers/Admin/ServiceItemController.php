<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceItemRequest;
use App\Http\Requests\UpdateServiceItemRequest;
use App\Http\Resources\ServiceItemResource;
use App\Models\ServiceItem;
use App\Models\ServiceType;
use App\Services\ServiceItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ServiceItemService $serviceItemService): Response
    {
        $serviceItems = $serviceItemService->getServiceItems();

        return Inertia::render('Admin/ServiceItem/ServiceItemIndex', [
            'serviceItems' => ServiceItemResource::collection($serviceItems),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceItemRequest $request, ServiceItemService $serviceItemService): RedirectResponse
    {
        $serviceItemService->create($request);

        return redirect()->route('admin.service-items.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/ServiceItem/ServiceItemForm', [
            'serviceTypeOptions' => ServiceType::pluck('name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceItem $serviceItem): Response
    {
        return Inertia::render('Admin/ServiceItem/ServiceItemForm', [
            'serviceItem' => ServiceItemResource::make($serviceItem)->resolve(),
            'serviceTypeOptions' => ServiceType::pluck('name', 'id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceItem $serviceItem): Response
    {
        return Inertia::render('Admin/ServiceItem/ServiceItemForm', [
            'serviceItem' => ServiceItemResource::make($serviceItem->load('servicePrices'))->resolve(),
            'serviceTypeOptions' => ServiceType::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceItemRequest $request, ServiceItem $serviceItem, ServiceItemService $serviceItemService): RedirectResponse
    {
        $serviceItemService->update($serviceItem, $request);

        return redirect()->route('admin.service-items.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceItem $serviceItem, ServiceItemService $serviceItemService): RedirectResponse
    {
        $serviceItemService->delete($serviceItem);

        return redirect()->route('admin.service-items.index')->with(['message' => 'Deleted successfully']);
    }
}
