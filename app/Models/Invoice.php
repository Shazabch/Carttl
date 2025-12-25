<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    // Invoice.php
public function booking()
{
    return $this->belongsTo(Booking::class, 'booking_id'); // adjust foreign key if needed
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
