<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use App\Settings\FinanceSettings;
use App\Settings\GeneralSettings;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GeneralSettings $settings): Response
    {
        return Inertia::render('Settings/GeneralSetting', [
            'settings' => $settings,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function general(GeneralSettings $settings): Response
    {
        return Inertia::render('Settings/GeneralSetting', [
            'settings' => $settings,
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
    public function finance(FinanceSettings $settings): Response
    {
        return Inertia::render('Settings/FinanceSetting', [
            'settings' => $settings,
        ]);
    }
}
