<?php

namespace App\Services;

use App\Http\Requests\StoreServiceDetailRequest;
use App\Http\Requests\UpdateServiceDetailRequest;
use App\Models\ServiceDetail;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceDetailService
{
    /**
     * Get paginated service details with filters and sorting.
     */
    public function getServiceDetails()
    {
        return QueryBuilder::for(ServiceDetail::class)
            ->allowedFilters([
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('service_id'),
                AllowedFilter::exact('service_item_id'),
                AllowedFilter::exact('unit_id'),
                AllowedFilter::partial('price'),
                AllowedFilter::callback('category', function ($query, $value) {
                    $query->whereHas('category', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('service', function ($query, $value) {
                    $query->whereHas('service', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('serviceItem', function ($query, $value) {
                    $query->whereHas('serviceItem', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('unit', function ($query, $value) {
                    $query->whereHas('unit', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['created_at', 'price'])
            ->with(['serviceItem', 'service', 'category', 'unit'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new service detail along with service prices and handle file upload.
     */
    public function create(StoreServiceDetailRequest $request): ServiceDetail
    {
        // Create the ServiceDetail
        $serviceDetail = ServiceDetail::create($request->all());


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
    }

    /**
     * Update an existing service detail along with its service prices and handle file upload.
     */
    public function update(ServiceDetail $serviceDetail, UpdateServiceDetailRequest $request): ServiceDetail
    {

        // Update the ServiceDetail
        $serviceDetail->update($request->all());

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

    /**
     * Delete a service detail.
     */
    public function delete(ServiceDetail $serviceDetail): void
    {
        $serviceDetail->delete();
    }
}
