<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'actual_name' => $this->actual_name,
            'short_name' => $this->short_name,
            'allow_decimal' => $this->allow_decimal,
            'status' => $this->status,
        ];
    }
}
