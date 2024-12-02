<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_uuid' => $this->order_uuid,
            'sub_total' => $this->sub_total,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->format('d/m/Y H:s'),
            'payments' => PaymentResource::make($this->whenLoaded('payments')),
            'store' => StoreResource::make($this->whenLoaded('store')),
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'order_details' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
