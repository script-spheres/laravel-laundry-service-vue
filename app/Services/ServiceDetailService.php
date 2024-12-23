<?php

namespace App\Services;

use App\Http\Requests\StoreServiceDetailRequest;
use App\Http\Requests\UpdateServiceDetailRequest;
use App\Models\ServiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceDetailService
{
    /**
     * Get paginated service details with filters and sorting.
     */
    public function getServiceDetails()
    {
        return QueryBuilder::for(ServiceDetail::class)
            ->allowedFilters(['id', 'name'])
            ->with('serviceDetails')
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service detail along with service prices and handle file upload.
     */
    public function create(StoreServiceDetailRequest $request): ServiceDetail
    {
        return DB::transaction(function () use ($request) {
            $attributes = $request->validated();
            $servicePrices = $attributes['service_prices'] ?? [];

            // Create the ServiceDetail
            $serviceDetail = ServiceDetail::create($attributes);

            // Attach associated service prices if provided
            if (!empty($servicePrices)) {
                $serviceDetail->servicePrices()->createMany($servicePrices);
            }

            // Handle the file upload with FilePond
            if ($request->has('image')) {
                $fileInfo = Filepond::field($request->image)->moveTo('service-details/' . Str::random(10));

                if ($fileInfo) {
                    $serviceDetail->update([
                        'image' => $this->extractFileData($fileInfo),
                    ]);
                }
            }

            return $serviceDetail;
        });
    }

    /**
     * Update an existing service detail along with its service prices and handle file upload.
     */
    public function update(ServiceDetail $serviceDetail, UpdateServiceDetailRequest $request): ServiceDetail
    {
        return DB::transaction(function () use ($serviceDetail, $request) {
            $attributes = $request->validated();
            $servicePrices = $attributes['service_prices'] ?? [];

            // Update the ServiceDetail
            $serviceDetail->update($attributes);

            // Sync service prices (delete old and add new)
            if (!empty($servicePrices)) {
                $serviceDetail->servicePrices()->delete();
                $serviceDetail->servicePrices()->createMany($servicePrices);
            }

            // Handle the file upload with FilePond
            if ($request->has('new_image')) {
                $fileInfo = Filepond::field($request->new_image)->moveTo('service-details/' . Str::random(10));

                if ($fileInfo) {
                    $serviceDetail->update([
                        'image' => $this->extractFileData($fileInfo),
                    ]);
                }
            }

            return $serviceDetail;
        });
    }

    /**
     * Delete a service detail.
     */
    public function delete(ServiceDetail $serviceDetail): void
    {
        $serviceDetail->delete();
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
