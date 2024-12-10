<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all orders
        $orders = Order::query()->get();

        // Filter orders based on order status
        $pendingOrders = $orders->where('order_status', 'pending');
        $inProgressOrders = $orders->where('order_status', 'in-progress');
        $readyToDeliverOrders = $orders->where('order_status', 'ready-to-deliver');
        $deliveredOrders = $orders->where('order_status', 'delivered');

        // Return the data to the Inertia view
        return Inertia::render('Order/OrderStatus', [
            // Resolve collections and pass to Inertia as arrays
            'pendingOrders' => OrderResource::collection($pendingOrders)->resolve(),
            'inProgressOrders' => OrderResource::collection($inProgressOrders)->resolve(),
            'readyToDeliverOrders' => OrderResource::collection($readyToDeliverOrders)->resolve(),
            'deliveredOrders' => OrderResource::collection($deliveredOrders)->resolve(),
            'services' => Service::pluck('name', 'id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order, OrderService $orderService)
    {
        $orderService->update($order, $request);

        return redirect()->route('orders-status.index')->with(['message' => 'Updated successfully']);
    }
}

