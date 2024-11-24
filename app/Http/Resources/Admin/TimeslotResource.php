<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\OutletResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeslotResource extends JsonResource
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
            'outlet_id' => $this->outlet_id,
            'table_id' => $this->table_id,
            'booking_uuid' => $this->booking_uuid,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'booking_date' => $this->booking_date,
            'no_of_people' => $this->no_of_people,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'customer_notes' => $this->customer_notes,
            'booking_status' => $this->booking_status,
            'outlet' => OutletResource::make($this->whenLoaded('outlet')),
            'table' => ExpenseResource::make($this->whenLoaded('table')),
            'created_at' => $this->when($this->created_at, $this->created_at->format('Y-m-d H:i:s')),
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
        // Example condition to include extra info, modify as needed
        return $this->booking_status === 'confirmed';
    }
}
