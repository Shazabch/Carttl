<?php

namespace App\Models;

use App\Enums\MileageRange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SaleEnquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mileage' => 'integer',
    ];

    /**
     * Get the set of images associated with the sale enquiry.
     */
    public function imageSet(): HasOne
    {
        return $this->hasOne(SaleEnquiryImage::class, 'sale_enquiry_id');
    }

    /**
     * Get the brand that the enquiry belongs to.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the vehicle model that the enquiry belongs to.
     *
     * We explicitly define the foreign key as 'make_id' because it doesn't
     * follow the standard Laravel convention of 'vehicle_model_id'.
     */
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
}
