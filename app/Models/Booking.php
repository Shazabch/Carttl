<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    protected $casts = [
    'services' => 'array',
    'fixed_fees' => 'array',
];

    public function vehicle()
{
    return $this->belongsTo(Vehicle::class, 'vehicle_id');
}
 public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


}
