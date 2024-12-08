<?php

namespace App\Http\Resources;

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
            'day' => $this->day,
            'timeslots' => $this->getFormattedTimeslots(),
            'status' => $this->status,
        ];
    }



    /**
     * Format the timeslots to a specific structure.
     *
     * @return array
     */
    private function getFormattedTimeslots(): array
    {
        $timeslots = json_decode($this->timeslots, true);

        // Format timeslots as needed (e.g., converting them to a more readable format)
        return array_map(function ($timeslot) {
            return [
                'start_time' => $timeslot['start_time'],
                'end_time' => $timeslot['end_time'],
            ];
        }, $timeslots);
    }
}
