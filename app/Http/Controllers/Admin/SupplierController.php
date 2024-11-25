<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SupplierService $supplierService)
    {
        $suppliers = $supplierService->getSuppliers();

        return Inertia::render('Admin/Supplier/SupplierIndex', [
            'suppliers' => SupplierResource::collection($suppliers),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Supplier/SupplierForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request, SupplierService $supplierService)
    {
        $supplierService->create($request);

        return redirect()->route('admin.suppliers.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return Inertia::render('Admin/Supplier/SupplierForm', [
            'supplier' => SupplierResource::make($supplier)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return Inertia::render('Admin/Supplier/SupplierForm', [
            'supplier' => SupplierResource::make($supplier)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier, SupplierService $supplierService)
    {
        $supplierService->update($supplier, $request);

        return redirect()->route('admin.suppliers.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier, SupplierService $supplierService)
    {
        $supplierService->delete($supplier);

        return redirect()->route('admin.suppliers.index')->with(['message' => 'Deleted successfully']);
    }
}
