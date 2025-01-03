<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'order_id' => $this->order_id,
            'serviceable_type' => $this->getServiceableType(),
            'serviceable_id' => $this->serviceable_id,
            'info' => $this->info,
            'price' => number_format($this->price, 2),
            'quantity' => $this->quantity,
            'total' => number_format($this->price * $this->quantity, 2),
        ];
    }

    /**
     * Custom logic to return serviceable_type as 'service' or 'addon-service'
     */
    private function getServiceableType(): string
    {
        if ($this->serviceable_type === 'App\Models\ServiceDetail') {
            return 'service';
        }

        if ($this->serviceable_type === 'App\Models\AddonService') {
            return 'addon-service';
        }

        // Default case (in case no matching type is found)
        return 'unknown';
    }
}
