<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleEnquiry;

class PurchaseEnquiryController extends Controller
{
    
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $search = $request->get('search', '');
        $vehicleId = $request->get('vehicle_id');
        $perPage = $request->get('per_page', 10);

        $enquiries = VehicleEnquiry::query()
            ->where('type', 'purchase')
            ->with(['vehicle:id,title', 'imageSet'])
            // Agent role restriction - show enquiries from their assigned customers
            ->when($user && $user->hasRole('agent'), fn($query) =>
                $query->whereHas('user', fn($q) =>
                    $q->where('agent_id', $user->id)
                )
            )
            ->when($vehicleId, function ($query) use ($vehicleId) {
                $query->where('vehicle_id', $vehicleId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('vehicle', function ($v) use ($search) {
                          $v->where('title', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }

    
    public function show($id)
    {
        $enquiry = VehicleEnquiry::where('type', 'purchase')
            ->with(['vehicle:id,title', 'imageSet'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $enquiry,
        ]);
    }

   
    public function destroy($id)
    {
        $enquiry = VehicleEnquiry::where('type', 'purchase')->findOrFail($id);
        $enquiry->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Purchase enquiry deleted successfully.',
        ]);
    }
}
