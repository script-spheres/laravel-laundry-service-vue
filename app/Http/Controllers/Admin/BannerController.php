<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Http\Resources\Admin\BannerResource;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BannerService $bannerService)
    {
        $banners = $bannerService->getBanners();

        return Inertia::render('Admin/Banner/BannerIndex', [
            'banners' => BannerResource::collection($banners),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Banner/BannerForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request, BannerService $bannerService)
    {
        $bannerService->create($request);

        return redirect()->route('admin.banners.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return Inertia::render('Admin/Banner/BannerForm', [
            'banner' => BannerResource::make($banner)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return Inertia::render('Admin/Banner/BannerForm', [
            'banner' => BannerResource::make($banner)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner, BannerService $bannerService)
    {
        $bannerService->update($banner, $request);

        return redirect()->route('admin.banners.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner, BannerService $bannerService)
    {
        $bannerService->delete($banner);

        return redirect()->route('admin.banners.index')->with(['message' => 'Deleted successfully']);
    }
}
