<?php

namespace App\Http\Resources\Admin;

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
            'table_id' => $this->table_id,
            'order_email' => $this->order_email,
            'sub_total' => $this->sub_total,
            'tax_percentage' => $this->tax_percentage,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'order_type' => $this->order_type,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'payment_mode' => $this->payment_mode,
            'serve_status' => $this->serve_status,
            'kitchen_status' => $this->kitchen_status,
            'created_at' => $this->created_at->format('d/m/Y H:s'),
            'outlet' => ExpenseResource::make($this->whenLoaded('outlet')),
            'Table' => ExpenseResource::make($this->whenLoaded('Table')),
            'Customer' => CustomerResource::make($this->whenLoaded('Customer')),
            'order_details' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
