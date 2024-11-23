<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'outlet_id' => $this->outlet_id,
            'outlet' => OutletResource::make($this->whenLoaded('outlet')),
            'table_no' => $this->table_no,
            'capacity' => $this->capacity,
            'booking_status' => $this->booking_status,
            'qr_image' => $this->qr_image,
            'scan_table_url' => url('scan-Table-qr', $this->table_uuid),
            'active_status' => $this->active_status,
        ];
    }
}
