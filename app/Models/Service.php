<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['consultant_id', 'service_name', 'description', 'price', 'duration'];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
