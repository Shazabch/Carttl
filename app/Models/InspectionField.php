<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionField extends Model
{
    protected $guarded=[];
       public function report()
    {
        return $this->belongsTo(VehicleInspectionReport::class, 'vehicle_inspection_report_id');
    }

    public function files()
    {
        return $this->hasMany(InspectionFieldImage::class, 'inspection_field_id');
    }
}
