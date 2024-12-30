<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = null;

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
            'order_display_id' => $this->order_display_id,
            'customer_id' => $this->customer_id,
            'store_id' => $this->store_id,
            'total_weight_kg' => $this->total_weight_kg,
            'sub_total' => $this->sub_total,
            'total_amount' => $this->total_amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'paid_amount' => $this->paid_amount,
            'delivery_date' => $this->delivery_date->format('Y-m-d'),
            'quick_note' => $this->quick_note,
            'order_status' => $this->order_status,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'store' => StoreResource::make($this->whenLoaded('store')),
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'order_details' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
            'order_label' => OrderLabelResource::make($this->whenLoaded('orderLabel')),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
