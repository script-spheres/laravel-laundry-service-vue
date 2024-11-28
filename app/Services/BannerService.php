<?php

namespace App\Services;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
     * @throws FileNotFoundException
     */
    public function create(StoreBannerRequest $request): Banner
    {
        // Save the banner data first (without the image)
        $attributes = $request->validated();
        $banner = Banner::create($attributes);

        // Handle the file upload with FilePond after saving the banner
        $fileInfo = Filepond::field($request->image)->moveTo('banners/banner-'.Str::random(10));

        if ($fileInfo) {
            // Store only the necessary file information in the database
            $banner->update([
                'image' => $this->extractFileData($fileInfo)
            ]);
        }

        // Return the updated banner
        return $banner;
    }

    /**
     * Update an existing banner.
     * @throws FileNotFoundException
     */
    public function update(Banner $banner, UpdateBannerRequest $request): Banner
    {
        // Update the other banner attributes (without changing the image)
        $attributes = $request->validated();

        // Handle the new image (if present)
        $fileInfo = Filepond::field($request->new_image)->moveTo('banners/banner-'.Str::random(10));

        // Check for new_image and update if necessary
        if ($fileInfo) {
            // Delete the old image from storage if it exists
            if ($banner->image) {
                Storage::delete($banner->image['location']);
            }

            // Store only the necessary file information in the database
            $attributes['image'] = $this->extractFileData($fileInfo);
        }

        // Update the banner with the new image information
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
            Storage::delete($banner->image['location']);
        }

        // Delete the banner itself
        $banner->delete();
    }

    /**
     * Helper function to extract the necessary file data.
     */
    private function extractFileData($fileInfo): array
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
