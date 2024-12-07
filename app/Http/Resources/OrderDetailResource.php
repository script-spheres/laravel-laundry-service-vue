<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'restaurant_notes' => $this->restaurant_notes,
            'request_notes' => $this->request_notes,
            'serve_status' => $this->serve_status,
            'kitchen_status' => $this->kitchen_status,
            'order_status' => $this->order_status,
            'order' => OrderResource::make($this->whenLoaded('order')),
        ];
    }
}
