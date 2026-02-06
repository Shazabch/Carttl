<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'phone',
        'photo',
        'target',
        'password',
        'role',
        'package_id',
        'status',
        'is_approved',
        'warranty',
        'asking_price',
        'auction_price',
        'notes',
        'user_documents',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_documents' => 'array',
        ];
    }
    public function favoriteVehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'user_vehicle_favorites')->withTimestamps();
    }

    public function bids()
    {
        return $this->hasMany(VehicleBid::class);
    }

   public function assignedCustomers()
{
    return $this->hasMany(AgentCustomer::class, 'agent_id');
}


   
    public function customers()
{
    return $this->hasMany(User::class, 'agent_id');
}

public function agent()
{
    return $this->belongsTo(User::class, 'agent_id');
}


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function vehicleBids()
{
    return $this->hasMany(VehicleBid::class, 'user_id');
}

public function package()
{
    return $this->belongsTo(Package::class, 'package_id');
}


}