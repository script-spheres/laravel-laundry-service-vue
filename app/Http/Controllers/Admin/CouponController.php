<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Http\Resources\Api\CouponResource;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CouponService $couponService)
    {
        $coupons = $couponService->getCoupons();

        return inertia('Admin/Coupon/CouponIndex', [
            'coupons' => CouponResource::collection($coupons),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Coupon/CouponForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request, CouponService $couponService)
    {
        $couponService->create($request);

        return redirect()->route('admin.coupons.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return inertia('Admin/Coupon/CouponForm', [
            'coupon' => CouponResource::make($coupon)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return inertia('Admin/Coupon/CouponForm', [
            'coupon' => CouponResource::make($coupon)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon, CouponService $couponService)
    {
        $couponService->update($coupon, $request);

        return redirect()->route('admin.coupons.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon, CouponService $couponService)
    {
        $couponService->delete($coupon);

        return redirect()->route('admin.coupons.index')->with(['message' => 'Deleted successfully']);
    }
}
