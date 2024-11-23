<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'supplier_id' => $this->supplier_id,
            'invoice_no' => $this->invoice_no,
            'purchase_date' => $this->purchase_date,
            'details' => $this->details,
            'grand_total' => $this->grand_total,
            'paid_amount' => $this->paid_amount,
            // Conditional relationship example:
            'supplier' => $this->when($this->relationLoaded('supplier'), function () {
                return new StoreResource($this->supplier);
            }),
            // Conditional attribute formatting:
            'formatted_purchase_date' => $this->when($this->purchase_date, function () {
                return $this->purchase_date->format('Y-m-d');
            }),
            // Include items as a nested resource collection:
            'items' => PurchaseItemResource::collection($this->whenLoaded('purchaseItems')),
            // Additional attributes based on conditions or methods:
            'is_paid_in_full' => $this->when($this->isPaidInFull(), true),
            // Include extra information conditionally:
            'extra_info' => $this->when($this->shouldIncludeExtraInfo(), function () {
                return [
                    'additional_field' => 'value',
                ];
            }),
        ];
    }

    /**
     * Determine if the purchase is paid in full.
     *
     * @return bool
     */
    private function isPaidInFull(): bool
    {
        return $this->paid_amount >= $this->grand_total;
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
