<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use App\Settings\BusinessSettings;
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
    public function index(): Response
    {
        $generalSettings = app(GeneralSettings::class);
        $businessSettings = app(BusinessSettings::class);
        $financeSettings = app(FinanceSettings::class);

        // Pass the settings to the Inertia view
        return Inertia::render('Settings/SettingIndex', [
            'generalSettings' => $generalSettings,
            'businessSettings' => $businessSettings,
            'financeSettings' => $financeSettings,
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
    public function finance(): Response
    {
        return Inertia::render('Settings/FinanceSetting', [
            'settings' => $settings,
        ]);
    }
}
