<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;

class TestimonialController extends Controller
{
      public function getAllTestimonials()
    {
        $testimonials = Testimonial::where('status',1)->get();

        return response()->json([
            'status' => 'success',
            'data' => $testimonials,
        ]);
    }
}
