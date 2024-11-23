<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExpenseRequest;
use App\Http\Requests\Admin\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ExpenseService $expenseService)
    {
        $expenses = $expenseService->getExpenses();

        return inertia('Admin/Expense/ExpenseIndex', [
            'expenses' => ExpenseResource::collection($expenses),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Expense/ExpenseForm');
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
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return inertia('Admin/Expense/ExpenseForm', [
            'expense' => ExpenseResource::make($expense)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return inertia('Admin/Expense/ExpenseForm', [
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
