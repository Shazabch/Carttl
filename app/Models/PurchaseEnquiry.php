<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseEnquiry extends Model
{
     public function vehicle()
{
    return $this->belongsTo(\App\Models\Vehicle::class, 'vehicle_id');
}
    protected $guarded=[];
}
