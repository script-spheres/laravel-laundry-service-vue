<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now()->format('Y-m-d');

        $orders = Order::with(['orderDetails', 'customer', 'payments', 'orderLabel'])->where('order_status', 'delivered')
            ->whereDate('delivery_date', $today)
            ->get();

        // Count the number of orders in each status
        $pending = Order::whereOrderStatus('pending')->count();
        $processing = Order::whereOrderStatus('processing')->count();
        $readyToDeliver = Order::whereOrderStatus('ready_to_deliver')->count();
        $delivered = Order::whereOrderStatus('delivered')->count();

        // Pass the data to the view
        return Inertia::render('Dashboard', [
            'todayDelivery' => OrderResource::collection($orders),
            'orderStatusCounts' => [
                ['label' => 'Pending', 'value' => $pending],
                ['label' => 'Processing', 'value' => $processing],
                ['label' => 'Ready To Deliver', 'value' => $readyToDeliver],
                ['label' => 'Delivered', 'value' => $delivered],
            ],
        ]);
    }

}
