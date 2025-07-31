<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle; // Import the Vehicle model
use Illuminate\Http\Request;

class VehicleInspectionController extends Controller
{
    /**
     * Show the form to create or edit an inspection report for a specific vehicle.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {

        dd('ddd');
        $vehicle=$request->vehicle_id ?? null;
        return view('admin.inspection.generate-report', [
            'vehicle' => $vehicle,
        ]);
    }
}