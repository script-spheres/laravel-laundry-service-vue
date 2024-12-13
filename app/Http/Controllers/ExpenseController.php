<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Store;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ExpenseService $expenseService): Response
    {
        $expenses = $expenseService->getExpenses();

        return Inertia::render('Expense/ExpenseIndex', [
            'storeOptions' => Store::pluck('name','id'),
            'expenses' => ExpenseResource::collection($expenses),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request, ExpenseService $expenseService): RedirectResponse
    {
        $expenseService->create($request);

        return redirect()->route('expenses.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Expense/ExpenseForm', [
            'expenseTypeOptions' => ExpenseType::pluck('name', 'id'),
            'storeOptions' => Store::pluck('name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): Response
    {
        return Inertia::render('Expense/ExpenseForm', [
            'expense' => ExpenseResource::make($expense)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense): Response
    {
        return Inertia::render('Expense/ExpenseForm', [
            'expenseTypeOptions' => ExpenseType::pluck('name', 'id'),
            'storeOptions' => Store::pluck('name', 'id'),
            'expense' => ExpenseResource::make($expense)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense, ExpenseService $expenseService): RedirectResponse
    {
        $expenseService->update($expense, $request);

        return redirect()->route('expenses.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense, ExpenseService $expenseService): RedirectResponse
    {
        $expenseService->delete($expense);

        return redirect()->route('expenses.index')->with(['message' => 'Deleted successfully']);
    }
}
