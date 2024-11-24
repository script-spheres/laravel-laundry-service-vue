<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use RahulHaque\Filepond\Facades\Filepond;

class BannerService
{
    /**
     * Get paginated banners with filters and sorting.
     */
    public function getBanners()
    {
        return QueryBuilder::for(Banner::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('title'),
                AllowedFilter::exact('active_status'),
            ])
            ->allowedSorts(['title', 'created_at'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new banner.
     */
    public function create(StoreBannerRequest $request): Banner
    {
        $attributes = $request->validated();

        $fileInfo = Filepond::field($request->image)->moveTo('banners/banner-'.Str::random(10));

        if ($fileInfo) {
            // Store the new image
            $attributes['image'] = $fileInfo;
        }


        return Banner::create($attributes);
    }

    /**
     * Update an existing banner.
     */
    public function update(Banner $banner, UpdateBannerRequest $request): Banner
    {
        $attributes = $request->validated();
        $fileInfo = Filepond::field($request->new_image)->moveTo('banners/banner-'.Str::random(10));

        // Check for new_image and update if necessary
        if ($fileInfo) {
            // Delete the old image if it exists
            if ($banner->image) {
                Storage::delete($banner->image);
            }
            // Store the new image
            $attributes['image'] = $fileInfo;
        }

        // Update the banner attributes
        $banner->update($attributes);

        return $banner;
    }

    /**
     * Delete a banner.
     */
    public function delete(Banner $banner): void
    {
        // Delete the image from storage if it exists
        if ($banner->image) {
            Storage::delete($banner->image);
        }

        $banner->delete();
    }
}
