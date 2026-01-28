<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Booking extends Model
{
    use LogsActivity;
    
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
