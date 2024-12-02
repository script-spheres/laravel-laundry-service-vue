<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Order/OrderStatus', [
            'pendingOrders' => Order::where('order_status', 'pending')->get(),
            'inProgressOrders' => Order::where('order_status', 'in-progress')->get(),
            'readyToDeliverOrders' => Order::where('order_status', 'ready-to-deliver')->get(),
            'deliveredOrders' => Order::where('order_status', 'delivered')->get(),
            'serviceTypes' => ServiceType::pluck('name', 'id'),
            'filters' => $request->get('filter'),
        ]);
    }
}
