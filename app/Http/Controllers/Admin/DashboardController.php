<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccessoryRequest;
use App\Http\Requests\UpdateAccessoryRequest;
use App\Http\Resources\AccessoryResource;
use App\Models\Accessory;
use App\Services\AccessoryService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AccessoryService $accessoryService)
    {
        $accessories = $accessoryService->getAccessories();

        return Inertia::render('Admin/Dashboard', [
            'accessories' => AccessoryResource::collection($accessories),
            'reservations' => AccessoryResource::collection($accessories),
            'orders' => AccessoryResource::collection($accessories),
            'stats' => AccessoryResource::collection($accessories),
        ]);
    }
}
