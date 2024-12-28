<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'service_id' => $this->service_id,
            'service_item_id' => $this->service_item_id,
            'unit_id' => $this->unit_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'service' => ServiceResource::make($this->whenLoaded('service')),
            'service_item' => ServiceResource::make($this->whenLoaded('serviceItem')),
            'unit' => UnitResource::make($this->whenLoaded('unit')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
