<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderLabelRequest;
use App\Http\Requests\UpdateOrderLabelRequest;
use App\Http\Resources\OrderLabelResource;
use App\Models\OrderLabel;
use App\Services\OrderLabelService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OrderLabelService $orderLabelService)
    {
        $orderLabels = $orderLabelService->getOrderLabels();

        return Inertia::render('OrderLabel/OrderLabelIndex', [
            'orderLabels' => OrderLabelResource::collection($orderLabels),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('OrderLabel/OrderLabelForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderLabelRequest $request, OrderLabelService $orderLabelService)
    {
        $orderLabelService->create($request);

        return redirect()->route('order-labels.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderLabel $orderLabel)
    {
        return Inertia::render('OrderLabel/OrderLabelForm', [
            'orderLabel' => OrderLabelResource::make($orderLabel)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderLabel $orderLabel)
    {
        return Inertia::render('OrderLabel/OrderLabelForm', [
            'orderLabel' => OrderLabelResource::make($orderLabel)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderLabelRequest $request, OrderLabel $orderLabel, OrderLabelService $orderLabelService)
    {
        $orderLabelService->update($orderLabel, $request);

        return redirect()->route('order-labels.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderLabel $orderLabel, OrderLabelService $orderLabelService)
    {
        $orderLabelService->delete($orderLabel);

        return redirect()->route('order-labels.index')->with(['message' => 'Deleted successfully']);
    }
}
