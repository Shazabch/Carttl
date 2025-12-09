<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatusHistory extends Model
{

    public function creatorUser()
{
    return $this->belongsTo(User::class, 'creator');
}

    protected $guarded = [];
}

