<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleEnquiry extends Model
{
    protected $fillable = ['name', 'number', 'brand_id', 'make_id', 'mileage', 'specification', 'faq', 'notes'];
    public function imageSet()
    {
        return $this->hasOne(SaleEnquiryImage::class, 'sale_enquiry_id');
    }
}
