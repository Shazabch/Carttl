<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionFieldImage extends Model
{
    protected $guarded=[];
    protected $table = 'inspection_field_images';
    public function field()
    {
        return $this->belongsTo(InspectionField::class, 'inspection_field_id');
    }
}
