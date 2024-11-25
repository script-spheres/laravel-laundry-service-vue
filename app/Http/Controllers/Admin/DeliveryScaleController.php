<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryScaleRequest;
use App\Http\Requests\UpdateDeliveryScaleRequest;
use App\Http\Resources\DeliveryScaleResource;
use App\Models\DeliveryScale;
use App\Services\DeliveryScaleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeliveryScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DeliveryScaleService $deliveryScaleService)
    {
        $deliveryScales = $deliveryScaleService->getDeliveryScales();

        return Inertia::render('Admin/DeliveryScale/DeliveryScaleIndex', [
            'deliveryScales' => DeliveryScaleResource::collection($deliveryScales),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/DeliveryScale/DeliveryScaleForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryScaleRequest $request, DeliveryScaleService $deliveryScaleService)
    {
        $deliveryScaleService->create($request);

        return redirect()->route('admin.delivery-scales.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryScale $deliveryScale)
    {
        return Inertia::render('Admin/DeliveryScale/DeliveryScaleForm', [
            'deliveryScale' => DeliveryScaleResource::make($deliveryScale)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryScale $deliveryScale)
    {
        return Inertia::render('Admin/DeliveryScale/DeliveryScaleForm', [
            'deliveryScale' => DeliveryScaleResource::make($deliveryScale)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryScaleRequest $request, DeliveryScale $deliveryScale, DeliveryScaleService $deliveryScaleService)
    {
        $deliveryScaleService->update($deliveryScale, $request);

        return redirect()->route('admin.delivery-scales.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryScale $deliveryScale, DeliveryScaleService $deliveryScaleService)
    {
        $deliveryScaleService->delete($deliveryScale);

        return redirect()->route('admin.delivery-scales.index')->with(['message' => 'Deleted successfully']);
    }
}
