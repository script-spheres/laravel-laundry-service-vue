<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceType;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OrderService $orderService)
    {
        $orders = $orderService->getOrders();

        return inertia('Admin/Order/OrderIndex', [
            'orders' => OrderResource::collection($orders),
            'serviceTypes' => ServiceType::pluck('table_no','id'),
            'services' => Service::pluck('name','id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return inertia('Admin/Order/OrderForm',[
            'serviceTypes' => ServiceType::pluck('table_no','id'),
            'services' => Service::pluck('name','id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $orderService->create($request);

        return redirect()->route('admin.orders.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return inertia('Admin/Order/OrderShow', [
            'order' => OrderResource::make($order)->resolve(),
            'serviceTypes' => ServiceType::pluck('table_no','id'),
            'services' => Service::pluck('name','id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return inertia('Admin/Order/OrderForm', [
            'order' => OrderResource::make($order)->resolve(),
            'serviceTypes' => ServiceType::pluck('table_no','id'),
            'services' => Service::pluck('name','id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order, OrderService $orderService)
    {
        $orderService->update($order, $request);

        return redirect()->route('admin.orders.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, OrderService $orderService)
    {
        $orderService->delete($order);

        return redirect()->route('admin.orders.index')->with(['message' => 'Deleted successfully']);
    }
}
