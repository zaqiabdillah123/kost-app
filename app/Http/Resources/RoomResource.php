<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'room_number' => $this->room_number,
            'room_type' => $this->room_type,
            'floor' => $this->floor,
            'room_size' => $this->room_size,
            'monthly_price' => $this->monthly_price,
            'facilities' => $this->facilities,
            'description' => $this->description,
            'availability_status' => $this->availability_status,
            'image' => $this->image,
            'is_available' => $this->isAvailable(),
        ];
    }
}
