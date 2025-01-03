<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function daily()
    {
        return Inertia::render('ServiceType/ServiceTypeForm');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $serviceType)
    {
        return Inertia::render('ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceResource::make($serviceType)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $serviceType)
    {
        return Inertia::render('ServiceType/ServiceTypeForm', [
            'serviceType' => ServiceResource::make($serviceType)->resolve()
        ]);
    }

}
