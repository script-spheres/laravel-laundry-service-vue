<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'active_status' => $this->active_status,
            // Conditional inclusion example:
            'parent_category' => $this->when($this->relationLoaded('parentCategory'), function () {
                return new CategoryResource($this->parentCategory);
            }),
            // Another example with attribute inclusion:
            'created_at' => $this->when($this->created_at, $this->created_at->format('Y-m-d H:i:s')),
            'products_count' => $this->whenLoaded('products', function () {
                return $this->products->count();
            }),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            // Conditional inclusion based on a condition:
            'is_active' => $this->when($this->active_status === 1, true),
            // Include additional attributes based on a condition:
            'extra_info' => $this->when($this->shouldIncludeExtraInfo(), function () {
                return [
                    'additional_field' => 'value',
                ];
            }),
        ];
    }

    /**
     * Determine if extra info should be included.
     *
     * @return bool
     */
    private function shouldIncludeExtraInfo(): bool
    {
        // Example condition to include extra info
        return true;
    }
}
