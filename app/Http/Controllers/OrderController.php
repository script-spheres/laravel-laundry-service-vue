<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\AddonService;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Store;
use App\Services\OrderService;
use App\Services\ServiceDetailService;
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

        return Inertia::render('Order/OrderIndex', [
            'orders' => OrderResource::collection($orders),
            'services' => Service::pluck('name', 'id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $orderService->create($request);

        return redirect()->route('orders.create')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $serviceDetailsQuery = ServiceDetail::with(['serviceItem', 'service', 'category', 'unit']);

        $serviceDetailsQuery->when($request->input('filter.category_id'), function ($query, $categoryId) {
            $query->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        });

        $serviceDetailsQuery->when($request->input('filter.service_id'), function ($query, $serviceId) {
            $query->whereHas('service', function ($query) use ($serviceId) {
                $query->where('id', $serviceId);
            });
        });

        return Inertia::render('Order/OrderForm', [
            'services' => Service::where('status', 'active')->get(),
            'storeOptions' => Store::pluck('name', 'id'),
            'customerOptions' => Customer::pluck('name', 'id'),
            'addonServices' => AddonService::get(),
            'coupons' => Coupon::get(),
            'categories' => Category::get(),
            'serviceDetails' => $serviceDetailsQuery->get(),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return Inertia::render('Order/OrderShow', [
            'order' => OrderResource::make($order->load(['orderDetails', 'customer', 'payments', 'orderLabel'])),
            'services' => Service::get(),
            'customerOptions' => Customer::get(),
            'addonServices' => AddonService::get(),
            'coupons' => Coupon::get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Order $order)
    {
        $orderDetails = OrderDetails::where(['order_id',$order->id])->get();

        return Inertia::render('Order/OrderForm', [
            'order' => OrderResource::make($order)->resolve(),
            'orderDetails' => OrderDetailResource::collection($orderDetails)->resolve(),
            'services' => Service::where('status', 'active')->get(),
            'storeOptions' => Store::pluck('name', 'id'),
            'customerOptions' => Customer::pluck('name', 'id'),
            'addonServices' => AddonService::get(),
            'coupons' => Coupon::get(),
            'categories' => Category::get(),
            'serviceDetails' => (new ServiceDetailService())->getServiceDetails(),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order, OrderService $orderService)
    {
        $orderService->update($order, $request);

        return redirect()->route('orders.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, OrderService $orderService)
    {
        $orderService->delete($order);

        return redirect()->route('orders.index')->with(['message' => 'Deleted successfully']);
    }
}
