<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'gender' => $this->gender,
            'notes' => $this->notes,
            'is_vip' => $this->is_vip,
            'loyalty_points' => $this->loyalty_points,
            'favorite_dish' => $this->favorite_dish,
            'preferred_cuisine' => $this->preferred_cuisine,
            'dietary_restrictions' => $this->dietary_restrictions,
            'allergies' => $this->allergies,
            'preferred_contact_method' => $this->preferred_contact_method,
            'receive_promotions' => $this->receive_promotions,
        ];
    }
}
