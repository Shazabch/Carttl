<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleManagementController extends Controller
{
   
    public function index(Request $request)
    {
        $type = $request->get('type', 'all'); // 'sold', 'listed', 'pending', 'draft', or 'all'
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $query = Vehicle::query();

       
        if ($type === 'sold') {
            $query->where('status', 'sold');
        } elseif ($type === 'listed') {
            $query->where('status', 'published');
        } elseif ($type === 'pending') {
            $query->where('status', 'pending');
        } elseif ($type === 'draft') {
            $query->where('status', 'draft');
        }

      
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('vin', 'like', "%{$search}%");
            });
        }

      
        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $vehicles
        ]);
    }

   
    public function show($id)
    {
        $vehicle = Vehicle::with(['brand', 'vehicleModel', 'fuelType', 'transmission', 'bodyType'])
            ->find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $vehicle
        ]);
    }

    
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle deleted successfully.'
        ]);
    }
}
