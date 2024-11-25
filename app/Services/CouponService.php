<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;
use Spatie\QueryBuilder\QueryBuilder;

class CouponService
{
    /**
     * Get paginated coupons with filters and sorting.
     */
    public function getCoupons()
    {
        return QueryBuilder::for(Coupon::class)
            ->allowedFilters(['id', 'code'])
            ->allowedSorts(['code', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new coupon.
     */
    public function create(StoreCouponRequest $request): Coupon
    {
        $attributes = $request->validated();
        return Coupon::create($attributes);
    }

    /**
     * Update an existing coupon.
     */
    public function update(Coupon $coupon, UpdateCouponRequest $request): Coupon
    {
        $attributes = $request->validated();
        $coupon->update($attributes);
        return $coupon;
    }

    /**
     * Delete a coupon.
     */
    public function delete(Coupon $coupon): void
    {
        $coupon->delete();
    }
}
