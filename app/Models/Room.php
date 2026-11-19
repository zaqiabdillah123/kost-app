<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'floor',
        'room_size',
        'monthly_price',
        'facilities',
        'description',
        'availability_status',
        'image',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return $this->availability_status === 'Tersedia';
    }
}