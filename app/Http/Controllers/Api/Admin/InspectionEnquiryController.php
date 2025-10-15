<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InspectionEnquiry;

class InspectionEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'DESC');
        $perPage = $request->get('per_page', 10);

        $enquiries = InspectionEnquiry::query()
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }

   
    public function show($id)
    {
        $enquiry = InspectionEnquiry::with(['brand:id,name', 'vehicleModel:id,name'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $enquiry,
        ]);
    }

  
    public function destroy($id)
    {
        $enquiry = InspectionEnquiry::findOrFail($id);
        $enquiry->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Inspection enquiry deleted successfully.',
        ]);
    }
}
