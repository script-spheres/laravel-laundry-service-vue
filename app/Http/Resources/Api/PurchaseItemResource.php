<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'item_id' => $this->item_id,
            'item_type' => $this->item_type,
            'qty' => $this->qty,
            'rate' => $this->rate,
            'total' => $this->total,
            // Example of including additional relationships if needed
            // 'item' => new ItemResource($this->whenLoaded('item')),
        ];
    }
}
