<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'order_id' => $this->model_id,
            'customer_id' => $this->author_id,
            'title' => $this->title,
            'review' => $this->review,
            'rating' => $this->rating,
            'in_testimonial' => $this->in_testimonial,
            'order' => OrderResource::make($this->whenLoaded('model')),
            'customer' => CustomerResource::make($this->whenLoaded('author')),
        ];
    }
}
