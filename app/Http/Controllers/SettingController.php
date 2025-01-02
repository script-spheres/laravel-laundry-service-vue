<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\GeneralSettingsRequest;
use App\Http\Requests\Setting\BusinessSettingRequest;
use App\Http\Requests\Setting\FinanceSettingRequest;
use App\Settings\GeneralSettings;
use App\Settings\BusinessSettings;
use App\Settings\FinanceSettings;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Support\Str;

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
     * Store the General Settings.
     */
    public function storeGeneral(GeneralSettingsRequest $request, GeneralSettings $settings): RedirectResponse
    {
        $settings->slogan = $request->input('slogan');

        if ($request->has('new_logo')) {
            $fileInfo = Filepond::field($request->new_logo)->moveTo('settings/' . Str::random(10));
            if ($fileInfo) {
                $settings->logo = $this->extractFileData($fileInfo);
            }
        }

        if ($request->has('new_favicon')) {
            $fileInfo = Filepond::field($request->new_favicon)->moveTo('settings/' . Str::random(10));
            if ($fileInfo) {
                $settings->favicon = $this->extractFileData($fileInfo);
            }
        }

        $settings->save();

        // Redirect back with a success message
        return redirect()->route('settings.index')->with('message', 'General Settings updated successfully.');
    }

    /**
     * Store the Business Settings.
     */
    public function storeBusiness(BusinessSettingRequest $request, BusinessSettings $settings): RedirectResponse
    {
        $settings->address = $request->input('address');
        $settings->email = $request->input('email');
        $settings->save();

        // Redirect back with a success message
        return redirect()->route('settings.index')->with('message', 'Business Settings updated successfully.');
    }

    /**
     * Store the Finance Settings.
     */
    public function storeFinance(FinanceSettingRequest $request, FinanceSettings $settings): RedirectResponse
    {
        // Handle Finance Settings
        $settings->tax_rate = $request->input('tax_rate');
        $settings->currency = $request->input('currency');
        $settings->currency_symbol = $request->input('currency_symbol');
        $settings->save();

        // Redirect back with a success message
        return redirect()->route('settings.index')->with('message', 'Finance Settings updated successfully.');
    }

    /**
     * Helper method to extract file data.
     */
    private function extractFileData($fileInfo)
    {
        return [
            'dirname' => $fileInfo['dirname'],
            'basename' => $fileInfo['basename'],
            'extension' => $fileInfo['extension'],
            'location' => $fileInfo['location'],
            'url' => $fileInfo['url']
        ];
    }
}
