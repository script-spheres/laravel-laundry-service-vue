<?php

namespace App\Services;

use App\Http\Requests\StoreAddonServiceRequest;
use App\Http\Requests\UpdateAddonServiceRequest;
use App\Models\AddonService;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AddonServiceService
{
    /**
     * Get paginated addon services with filters and sorting.
     */
    public function getAddonServices()
    {
        return QueryBuilder::for(AddonService::class)
            ->allowedIncludes(['parent', 'children'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new addon service.
     */
    public function create(StoreAddonServiceRequest $request): AddonService
    {
        $attributes = $request->validated();

        // Handle file upload directly
        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('addon_services');
        }

        return AddonService::create($attributes);
    }

    /**
     * Update an existing addon service.
     */
    public function update(AddonService $addonService, UpdateAddonServiceRequest $request): AddonService
    {
        $attributes = $request->validated();

        // Check for new_image and update if necessary
        if ($request->hasFile('new_image')) {
            // Delete the old image if it exists
            if ($addonService->image) {
                Storage::delete($addonService->image);
            }
            // Store the new image
            $attributes['image'] = $request->file('new_image')->store('addon_services');
        }

        // Update the addon service attributes
        $addonService->update($attributes);

        return $addonService;
    }

    /**
     * Delete an addon service.
     */
    public function delete(AddonService $addonService): void
    {
        // Delete the image from storage if it exists
        if ($addonService->image) {
            Storage::delete($addonService->image);
        }

        $addonService->delete();
    }
}
