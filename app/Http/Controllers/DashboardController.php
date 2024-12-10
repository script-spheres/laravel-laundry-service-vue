<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'orders' => Order::get(),
        ]);
    }
}
