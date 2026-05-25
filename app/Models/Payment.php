<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['booking_id', 'razorpay_payment_id', 'razorpay_order_id', 'amount', 'status', 'payment_method'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
