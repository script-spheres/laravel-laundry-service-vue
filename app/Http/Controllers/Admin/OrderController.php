<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\AddonService;
use App\Models\Order;
use App\Models\ServiceItem;
use App\Models\ServiceType;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OrderService $orderService)
    {
        $orders = $orderService->getOrders();

        return Inertia::render('Admin/Order/OrderIndex', [
            'orders' => OrderResource::collection($orders),
            'serviceTypes' => ServiceType::pluck('name','id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('Admin/Order/OrderForm',[
            'serviceTypes' => ServiceType::get(),
            'addonServices' => AddonService::get(),
            'serviceItems' => ServiceItem::with(['servicePrices','servicePrices.serviceType'])->get(),
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
        return Inertia::render('Admin/Order/OrderShow', [
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
        return Inertia::render('Admin/Order/OrderForm', [
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
