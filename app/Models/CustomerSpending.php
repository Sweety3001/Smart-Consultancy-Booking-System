<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSpending extends Model
{
    protected $fillable = ['customer_id', 'total_spent'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
