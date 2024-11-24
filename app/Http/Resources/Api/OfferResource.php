<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
            'discount_percentage' => $this->discount_percentage,
            'active_status' => $this->active_status,
        ];
    }
}
