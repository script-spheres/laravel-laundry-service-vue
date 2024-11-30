<?php

namespace App\Services;

use App\Http\Requests\StoreServiceItemRequest;
use App\Http\Requests\UpdateServiceItemRequest;
use App\Models\ServiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceItemService
{
    /**
     * Get paginated service items with filters and sorting.
     */
    public function getServiceItems()
    {
        return QueryBuilder::for(ServiceItem::class)
            ->allowedFilters(['id', 'name'])
            ->with('servicePrices')
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service item along with service prices and handle file upload.
     */
    public function create(StoreServiceItemRequest $request): ServiceItem
    {
        return DB::transaction(function () use ($request) {
            $attributes = $request->validated();
            $servicePrices = $attributes['service_prices'] ?? [];

            // Create the ServiceItem
            $serviceItem = ServiceItem::create($attributes);

            // Attach associated service prices if provided
            if (!empty($servicePrices)) {
                $serviceItem->servicePrices()->createMany($servicePrices);
            }

            // Handle the file upload with FilePond
            if ($request->has('image')) {
                $fileInfo = Filepond::field($request->image)->moveTo('service-items/' . Str::random(10));

                if ($fileInfo) {
                    $serviceItem->update([
                        'image' => $this->extractFileData($fileInfo),
                    ]);
                }
            }

            return $serviceItem;
        });
    }

    /**
     * Update an existing service item along with its service prices and handle file upload.
     */
    public function update(ServiceItem $serviceItem, UpdateServiceItemRequest $request): ServiceItem
    {
        return DB::transaction(function () use ($serviceItem, $request) {
            $attributes = $request->validated();
            $servicePrices = $attributes['service_prices'] ?? [];

            // Update the ServiceItem
            $serviceItem->update($attributes);

            // Sync service prices (delete old and add new)
            if (!empty($servicePrices)) {
                $serviceItem->servicePrices()->delete();
                $serviceItem->servicePrices()->createMany($servicePrices);
            }

            // Handle the file upload with FilePond
            if ($request->has('new_image')) {
                $fileInfo = Filepond::field($request->new_image)->moveTo('service-items/' . Str::random(10));

                if ($fileInfo) {
                    $serviceItem->update([
                        'image' => $this->extractFileData($fileInfo),
                    ]);
                }
            }

            return $serviceItem;
        });
    }

    /**
     * Delete a service item.
     */
    public function delete(ServiceItem $serviceItem): void
    {
        $serviceItem->delete();
    }

    /**
     * Extract and format file information for database storage.
     *
     * @param array $fileInfo
     * @return array
     */
    private function extractFileData(array $fileInfo): array
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
