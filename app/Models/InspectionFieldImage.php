<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionFieldImage extends Model
{
    protected $guarded=[];
    public function field()
    {
        return $this->belongsTo(InspectionField::class, 'inspection_field_id');
    }
}
