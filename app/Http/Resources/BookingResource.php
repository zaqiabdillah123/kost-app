<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'room' => $this->whenLoaded('room', fn () => RoomResource::make($this->room)),
            'tenant' => $this->whenLoaded('tenant', fn () => $this->tenant ? [
                'id' => $this->tenant->id,
                'full_name' => $this->tenant->full_name,
                'whatsapp_number' => $this->tenant->whatsapp_number,
            ] : null),
            'move_in_date' => $this->move_in_date?->toDateString(),
            'notes' => $this->notes,
            'booking_status' => $this->booking_status,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
