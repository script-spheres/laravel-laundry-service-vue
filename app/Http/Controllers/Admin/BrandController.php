<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BrandService $brandService)
    {
        $brands = $brandService->getBrands();

        return Inertia::render('Admin/Brand/BrandIndex', [
            'brands' => BrandResource::collection($brands),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Brand/BrandForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request, BrandService $brandService)
    {
        $brandService->create($request);

        return redirect()->route('admin.brands.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return Inertia::render('Admin/Brand/BrandForm', [
            'brand' => BrandResource::make($brand)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return Inertia::render('Admin/Brand/BrandForm', [
            'brand' => BrandResource::make($brand)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand, BrandService $brandService)
    {
        $brandService->update($brand, $request);

        return redirect()->route('admin.brands.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand, BrandService $brandService)
    {
        $brandService->delete($brand);

        return redirect()->route('admin.brands.index')->with(['message' => 'Deleted successfully']);
    }
}
