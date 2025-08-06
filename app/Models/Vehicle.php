<?php

namespace App\Models;

use App\Enums\MileageRange;
use App\Enums\VehicleColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Using $guarded = [] is convenient for development but for production,
     * consider using $fillable to explicitly list allowed fields.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     * This is important for booleans, dates, enums, and decimals.
     */
    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
        'engine_cc' => 'integer',
        'horsepower' => 'integer',
        'seats' => 'integer',
        'doors' => 'integer',
        'price' => 'decimal:2',
        'negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'is_auction' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'auction_end_date' => 'datetime',

    ];

    /**
     * Boot the model to attach event listeners.
     * Here, we automatically generate a slug when a new vehicle is created.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vehicle) {
            // Generate a unique slug from the title, year, and variant
            $baseSlug = Str::slug($vehicle->title . '-' . $vehicle->year . '-' . $vehicle->variant);
            $slug = $baseSlug;
            $count = 1;
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $vehicle->slug = $slug;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | "Belongs To" Relationships (One-to-Many Inverse)
    |--------------------------------------------------------------------------
    | These define the "parent" records of a vehicle.
    */

    /**
     * Get the brand of the vehicle.
     * Example: This is a "Toyota".
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the model of the vehicle.
     * Example: This is a "Camry".
     * This assumes you have renamed your column to `vehicle_model_id`.
     */
    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    /**
     * Get the body type of the vehicle.
     * Example: This is a "Sedan".
     */
    public function bodyType(): BelongsTo
    {
        return $this->belongsTo(BodyType::class);
    }

    /**
     * Get the fuel type of the vehicle.
     * Example: This vehicle uses "Gasoline".
     */
    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    /**
     * Get the transmission type of the vehicle.
     * Example: This vehicle is "Automatic".
     */
    public function transmission(): BelongsTo
    {
        return $this->belongsTo(Transmission::class);
    }

    /**
     * Get the user who listed this vehicle (optional).
     * Assumes you add a `user_id` foreign key to your `vehicles` table.
     */
    public function lister(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /*
    |--------------------------------------------------------------------------
    | "Has Many" Relationships
    |--------------------------------------------------------------------------
    | These define records that "belong to" this vehicle.
    */

    /**
     * Get all inspection records for this vehicle.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(VehicleInspectionReport::class);
    }

    /**
     * Get all images for this vehicle.
     * Assumes an `images` table with a `vehicle_id` foreign key.
     */


    /*
    |--------------------------------------------------------------------------
    | Many-to-Many Relationships
    |--------------------------------------------------------------------------
    | These define records connected via a pivot table.
    */

    /**
     * Get all the specific features for this particular vehicle (e.g., this car has a sunroof).
     * This requires a pivot table, e.g., `feature_vehicle`.
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'vehicle_features', 'vehicle_id', 'feature_id');
    }

    public function bids()
    {
        return $this->hasMany(VehicleBid::class)->orderBy('created_at', 'desc');
    }

    public function latestBid()
    {
        return $this->hasOne(VehicleBid::class)->latestOfMany();
    }
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(VehicleImage::class)->where('is_cover', true);
    }
    public function getMileageLabelAttribute()
    {
        try {
            return MileageRange::from((int) $this->mileage)->label();
        } catch (\ValueError $e) {
            return 'Unknown mileage';
        }
    }
    public function getColorLabelAttribute()
    {
        try {
            return VehicleColor::from((string) $this->color)->label();
        } catch (\ValueError $e) {
            return '';
        }
    }
}
