<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDamage extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'vehicle_id',
        'type',
        'body_part',
        'severity',
        'x',
        'y',
        'remark'
    ];
}
