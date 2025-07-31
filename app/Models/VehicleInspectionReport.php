<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'paintCondition' => 'array',
        'frontLeftTire' => 'array',
        'frontRightTire' => 'array',
        'rearLeftTire' => 'array',
        'rearRightTire' => 'array',
        'seatsCondition' => 'array',
        'brakeDiscs' => 'array',
        'shockAbsorberOperation' => 'array',
    ];

    /**
     * Get the vehicle that this inspection report belongs to.
     */
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
}