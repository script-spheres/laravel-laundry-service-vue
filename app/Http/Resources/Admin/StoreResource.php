<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'address_lat' => $this->address_lat,
            'address_long' => $this->address_long,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'manager_name' => $this->manager_name,
            'manager_email' => $this->manager_email,
            'manager_phone_number' => $this->manager_phone_number,
            'additional_info' => $this->additional_info,
            'store_code' => $this->store_code,
            'active_status' => $this->active_status,
        ];
    }
}
