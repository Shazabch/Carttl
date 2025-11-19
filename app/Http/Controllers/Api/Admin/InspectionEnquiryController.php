<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InspectionEnquiry;
use App\Models\User;

class InspectionEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'DESC');
        $perPage = $request->get('per_page', 10);
        $enquiries = InspectionEnquiry::query()
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->when($user->role === 'inspector', function ($query) use ($user) {
                $query->where('inspector_id', $user->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
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
    public function allInspectors(Request $request)
    {
        $query = User::where('role', 'inspector');


        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $inspectors = $query->get(['id', 'name', 'email']);

        return response()->json([
            'status' => 'success',
            'data' => $inspectors
        ]);
    }
    public function assignInspector(Request $request)
    {
        $request->validate([
            'enquiry_id'   => 'required|exists:inspection_enquiries,id',
            'inspector_id' => 'required|exists:users,id',
        ]);

        $enquiry = InspectionEnquiry::find($request->enquiry_id);


        $inspector = User::where('id', $request->inspector_id)
            ->where('role', 'inspector')
            ->first();

        if (!$inspector) {
            return response()->json([
                'status' => 'error',
                'message' => 'The selected user is not an inspector.',
            ], 422);
        }


        $enquiry->inspector()->associate($inspector);
        $enquiry->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Inspector assigned successfully.',
            'data' => $enquiry->load('inspector')
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
