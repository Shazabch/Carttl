<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionEnquiry extends Model
{
       protected $guarded = [];
        public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'model');
    }
     public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'make' );
    }
      public function user()
     {
          return $this->belongsTo(User::class);
     }
     public function inspectionReports(): HasMany
    {
        return $this->hasMany(VehicleInspectionReport::class,'inspection_enquiry_id');
    }
}
