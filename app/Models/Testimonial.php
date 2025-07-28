<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $fillable = ['name', 'rank', 'comment'];
    protected $attributes = [
        'status' => true,
    ];
}
