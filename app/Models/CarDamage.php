<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDamage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'body_part',
        'severity',
        'x',
        'y',
        'remark'
    ];
}
