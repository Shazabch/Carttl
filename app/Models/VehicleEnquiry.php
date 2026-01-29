<?php

namespace App\Models;

use App\Enums\MileageRange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VehicleEnquiry extends Model
{
      public function vehicle()
{
    return $this->belongsTo(\App\Models\Vehicle::class, 'vehicle_id');
}
    public function imageSet(): HasOne
    {
        return $this->hasOne(SaleEnquiryImage::class, 'sale_enquiry_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
     public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'make_id');
    }

     public function getMileageLabelAttribute()
    {
        try {
            return MileageRange::from((int) $this->mileage)->label();
        } catch (\ValueError $e) {
            return 'Unknown mileage';
        }
    }
    protected $guarded=[];
}
