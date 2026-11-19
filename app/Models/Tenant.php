<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'full_name',
        'whatsapp_number',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}