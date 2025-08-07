<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InspectionEnquiry;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleManagerController extends Controller
{
    public function index($type)
    {
        return view('admin.vehicles.index',compact('type'));
    }
    public function details($id)
    {
        return view('admin.vehicles.details', ['id' => $id]);
    }
    public function generateInspectionVehicle($id)
    {
        $vehicle=Vehicle::find($id);
        $detailsItem =$vehicle->title .' ' . $vehicle->brand?->name .' '. $vehicle->vehicleModel?->name;
        return view('admin.inspection.vehicle.generate', ['id' => $id,'detailsItem' => $detailsItem]);
    }
    public function generateInspectionEnquiry($id)
    {
        $enq=InspectionEnquiry::find($id);
        $detailsItem =$enq->make .' '. $enq->model;
        return view('admin.inspection.enquiry.generate', ['id' => $id,'detailsItem' => $detailsItem]);
    }
}
