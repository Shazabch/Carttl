<?php

namespace App\Models;

use App\Enums\MileageRange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use DateTimeInterface;

class VehicleInspectionReport extends Model
{
    use HasFactory;

    /**
     * Use $guarded to allow mass assignment of all fields.
     */
    protected $guarded = [];

    /**
     * Automatically cast JSON columns to arrays and vice versa.
     */
    protected $casts = [
        'inspected_at' => 'datetime',
        'odometer' => 'integer',
        'paintCondition' => 'array',
        'frontLeftTire' => 'array',
        'frontRightTire' => 'array',
        'rearLeftTire' => 'array',
        'rearRightTire' => 'array',
        'seatsCondition' => 'array',
        'brakeDiscs' => 'array',
        'shockAbsorberOperation' => 'array',
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        // Force all dates to Dubai timezone when returning JSON
        return $date->timezone(config('app.timezone'))->format('Y-m-d H:i:s');
    }

    /**
     * Get the vehicle that this inspection report belongs to.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->inspected_at) {
                $model->inspected_at = now(); // uses app timezone
            }
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the user who performed the inspection.
     */
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'make');
    }
    public function images(): HasMany
    {
        return $this->hasMany(VehicleInspectionImage::class);
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(VehicleInspectionImage::class)->where('is_cover', true);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'model');
    }
    public function getOdometerLabelAttribute()
    {
        try {
            return MileageRange::from((int) $this->odometer)->label();
        } catch (\ValueError $e) {
            return 'Unknown mileage';
        }
    }
    public function damages(): HasMany
    {
        return $this->hasMany(CarDamage::class, 'inspection_id');
    }

    public function fields()
    {
        return $this->hasMany(InspectionField::class, 'vehicle_inspection_report_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
