<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseEnquiry extends Model
{
     public function vehicle()
{
    return $this->belongsTo(\App\Models\Vehicle::class, 'vehicle_id');
}
public function imageSet(): HasOne
    {
        return $this->hasOne(VehicleImage::class, 'vehicle_id');
    }
    protected $guarded=[];
}
