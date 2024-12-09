<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddonServiceResource;
use App\Services\AddonServiceService;
use Inertia\Inertia;

class FinancialReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AddonServiceService $addonServiceService): \Inertia\Response
    {
        $addonServices = $addonServiceService->getAddonServices();

        return Inertia::render('Admin/AddonService/AddonServiceIndex', [
            'addonServices' => AddonServiceResource::collection($addonServices),
            'filters' => $request->get('filter'),
        ]);
    }

}
