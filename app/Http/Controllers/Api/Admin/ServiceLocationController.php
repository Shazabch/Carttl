<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceLocation;

class ServiceLocationController extends Controller
{
    // Index: list all records
    public function index()
    {
        $data = ServiceLocation::all();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    // Store a Service
    public function storeService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_amount' => 'required|numeric',
        ]);

        $service = ServiceLocation::create([
            'service_name' => $request->service_name,
            'service_amount' => $request->service_amount,
            'type' => 'service'
        ]);

        return response()->json(['status' => 'success', 'data' => $service]);
    }

    // Store a Location
    public function storeLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        $location = ServiceLocation::create([
            'location' => $request->location,
            'type' => 'location'
        ]);

        return response()->json(['status' => 'success', 'data' => $location]);
    }

    // Update a Service
    public function updateService(Request $request, $id)
    {
        $service = ServiceLocation::where('id', $id)->where('type', 'service')->first();
        if (!$service) return response()->json(['status'=>'error','message'=>'Service not found'],404);

        $request->validate([
            'service_name' => 'sometimes|required|string|max:255',
            'service_amount' => 'sometimes|required|numeric',
        ]);

        $service->update($request->only('service_name','service_amount'));

        return response()->json(['status'=>'success','data'=>$service]);
    }

    // Update a Location
    public function updateLocation(Request $request, $id)
    {
        $location = ServiceLocation::where('id', $id)->where('type', 'location')->first();
        if (!$location) return response()->json(['status'=>'error','message'=>'Location not found'],404);

        $request->validate([
            'location' => 'sometimes|required|string|max:255',
        ]);

        $location->update($request->only('location'));

        return response()->json(['status'=>'success','data'=>$location]);
    }

    public function destroy($id)
{
    $item = ServiceLocation::find($id);

    if (!$item) {
        return response()->json([
            'status' => 'error',
            'message' => 'Record not found'
        ], 404);
    }

    $item->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Record deleted successfully'
    ]);
}

}
