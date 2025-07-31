<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
     public function vehicleDetails(){
        return view('detail');
    }
}
