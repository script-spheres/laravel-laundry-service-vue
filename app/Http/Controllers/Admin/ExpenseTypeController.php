<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\Store;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ExpenseService $expenseService)
    {
        $expenses = $expenseService->getExpenses();

        return Inertia::render('Admin/Expense/ExpenseIndex', [
            'expenses' => ExpenseResource::collection($expenses),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request, ExpenseService $expenseService)
    {
        $expenseService->create($request);

        return redirect()->route('admin.expenses.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Expense/ExpenseForm', [
            'storesOptions' => Store::pluck('name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return Inertia::render('Admin/Expense/ExpenseForm', [
            'expense' => ExpenseResource::make($expense)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return Inertia::render('Admin/Expense/ExpenseForm', [
            'storesOptions' => Store::pluck('name', 'id'),
            'expense' => ExpenseResource::make($expense)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense, ExpenseService $expenseService)
    {
        $expenseService->update($expense, $request);

        return redirect()->route('admin.expenses.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense, ExpenseService $expenseService)
    {
        $expenseService->delete($expense);

        return redirect()->route('admin.expenses.index')->with(['message' => 'Deleted successfully']);
    }
}
