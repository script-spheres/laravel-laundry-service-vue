<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreStoreRequest;
use App\Http\Requests\Api\UpdateStoreRequest;
use App\Http\Resources\Api\StoreResource;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, StoreService $storeService)
    {
        $stores = $storeService->getStores();

        return inertia('Admin/Store/StoreIndex', [
            'stores' => StoreResource::collection($stores),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Store/StoreForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request, StoreService $storeService)
    {
        $storeService->create($request);

        return redirect()->route('admin.stores.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return inertia('Admin/Store/StoreForm', [
            'store' => StoreResource::make($store)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        return inertia('Admin/Store/StoreForm', [
            'store' => StoreResource::make($store)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store, StoreService $storeService)
    {
        $storeService->update($store, $request);

        return redirect()->route('admin.stores.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store, StoreService $storeService)
    {
        $storeService->delete($store);

        return redirect()->route('admin.stores.index')->with(['message' => 'Deleted successfully']);
    }
}
