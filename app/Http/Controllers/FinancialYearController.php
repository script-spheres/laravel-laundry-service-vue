<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFinancialYearRequest;
use App\Http\Requests\UpdateFinancialYearRequest;
use App\Http\Resources\FinancialYearResource;
use App\Models\FinancialYear;
use App\Services\FinancialYearService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FinancialYearService $financialYearService)
    {
        $financialYears = $financialYearService->getFinancialYears();

        return Inertia::render('FinancialYear/FinancialYearIndex', [
            'financialYears' => FinancialYearResource::collection($financialYears),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('FinancialYear/FinancialYearForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinancialYearRequest $request, FinancialYearService $financialYearService)
    {
        $financialYearService->create($request);

        return redirect()->route('financial-years.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialYear $financialYear)
    {
        return Inertia::render('FinancialYear/FinancialYearForm', [
            'financialYear' => FinancialYearResource::make($financialYear)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialYear $financialYear)
    {
        return Inertia::render('FinancialYear/FinancialYearForm', [
            'financialYear' => FinancialYearResource::make($financialYear)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinancialYearRequest $request, FinancialYear $financialYear, FinancialYearService $financialYearService)
    {
        $financialYearService->update($financialYear, $request);

        return redirect()->route('financial-years.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialYear $financialYear, FinancialYearService $financialYearService)
    {
        $financialYearService->delete($financialYear);

        return redirect()->route('financial-years.index')->with(['message' => 'Deleted successfully']);
    }
}