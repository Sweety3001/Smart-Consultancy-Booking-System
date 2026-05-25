<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['customer_id', 'consultant_id', 'service_id', 'booking_date', 'booking_time', 'status', 'payment_status', 'total_amount', 'notes'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
