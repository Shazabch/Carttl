<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InspectionEnquiry extends Model
{
    use LogsActivity;
    
    protected $guarded = [];
    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'model');
    }
    public function statusHistories()
{
    return $this->hasMany(AppointmentStatusHistory::class, 'appointment_id');
}

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'make');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inspectionReport(): HasOne
    {
        return $this->hasOne(VehicleInspectionReport::class, 'inspection_enquiry_id');
    }
    public function inspectionReports()
{
    return $this->hasMany(VehicleInspectionReport::class, 'inspection_enquiry_id', 'id');
}

    
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
      public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
