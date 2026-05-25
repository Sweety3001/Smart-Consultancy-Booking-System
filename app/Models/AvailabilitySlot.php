<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $fillable = ['consultant_id', 'available_date', 'start_time', 'end_time', 'is_booked'];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
