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
            'expense_type' => ExpenseTypeResource::make($this->whenLoaded('expenseType')),
            'store' => StoreResource::make($this->whenLoaded('store')),
            'expense_type_id' => $this->expense_type_id,
            'store_id' => $this->store_id,
            'date' => $this->date->format('Y-m-d'),
            'amount' => $this->amount,
            'note' => $this->note,
        ];
    }
}
