<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseTypeRequest;
use App\Http\Requests\UpdateExpenseTypeRequest;
use App\Http\Resources\ExpenseTypeResource;
use App\Models\ExpenseType;
use App\Services\ExpenseTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ExpenseTypeService $expenseTypeService)
    {
        $expenseTypes = $expenseTypeService->getExpenseTypes();

        return Inertia::render('ExpenseType/ExpenseTypeIndex', [
            'expenseTypes' => ExpenseTypeResource::collection($expenseTypes),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseTypeRequest $request, ExpenseTypeService $expenseTypeService)
    {
        $expenseTypeService->create($request);

        return redirect()->route('expense-types.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ExpenseType/ExpenseTypeForm');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseType $expenseType)
    {
        return Inertia::render('ExpenseType/ExpenseTypeForm', [
            'expenseType' => ExpenseTypeResource::make($expenseType)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseType $expenseType)
    {
        return Inertia::render('ExpenseType/ExpenseTypeForm', [
            'expenseType' => ExpenseTypeResource::make($expenseType)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseTypeRequest $request, ExpenseType $expenseType, ExpenseTypeService $expenseTypeService)
    {
        $expenseTypeService->update($expenseType, $request);

        return redirect()->route('expense-types.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseType $expenseType, ExpenseTypeService $expenseTypeService)
    {
        $expenseTypeService->delete($expenseType);

        return redirect()->route('expense-types.index')->with(['message' => 'Deleted successfully']);
    }
}
