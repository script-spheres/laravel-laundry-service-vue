<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PurchaseService $purchaseService)
    {
        $purchases = $purchaseService->getPurchases();

        return Inertia::render('Admin/Purchase/PurchaseIndex', [
            'purchases' => PurchaseResource::collection($purchases),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Purchase/PurchaseForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request, PurchaseService $purchaseService)
    {
        $purchaseService->create($request);

        return redirect()->route('admin.purchases.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return Inertia::render('Admin/Purchase/PurchaseForm', [
            'purchase' => PurchaseResource::make($purchase)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        return Inertia::render('Admin/Purchase/PurchaseForm', [
            'purchase' => PurchaseResource::make($purchase)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase, PurchaseService $purchaseService)
    {
        $purchaseService->update($purchase, $request);

        return redirect()->route('admin.purchases.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase, PurchaseService $purchaseService)
    {
        $purchaseService->delete($purchase);

        return redirect()->route('admin.purchases.index')->with(['message' => 'Deleted successfully']);
    }
}
