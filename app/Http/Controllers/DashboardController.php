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
        $orders = Order::with(['orderDetails', 'customer', 'payments', 'orderLabel'])->get();

        return Inertia::render('Dashboard', [
            'orders' => OrderResource::collection($orders),
        ]);
    }
}
