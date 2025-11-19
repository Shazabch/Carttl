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
            ->with([
                'brand:id,name',
                'vehicleModel:id,name',
                'inspector:id,name,email,phone'
            ])
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


    public function getCustomers(Request $request)
    {
        $role = $request->query('role', 'customer'); // default to 'customer'
        $search = $request->query('search');

        $users = User::query()
            ->where('role', $role)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10); // pagination, 10 per page

        return response()->json([
            'status' => 'success',
            'message' => 'Customers fetched successfully.',
            'data' => $users
        ]);
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|string',
            'location'    => 'required|string|max:255',
            'year'        => 'required|string|max:4',
            'make'        => 'required|integer|exists:brands,id',
            'model'       => 'required|integer|exists:vehicle_models,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        try {

         
            // Fetch customer based on request
            $customer = User::findOrFail($request->user_id);

            // Auto-fill enquiry fields using **customer details**
            $validated['name']  = $customer->name;
            $validated['phone'] = $customer->phone;
            $validated['email'] = $customer->email;

            // Auto-set date & time
            $validated['date'] = now()->toDateString();
            $validated['time'] = now()->format('H:i');

            // Save admin ID (optional: tracking who created)
            $validated['user_id'] = $customer->id;

            $validated['type'] = 'inspection';

            // Create enquiry
            $enquiry = InspectionEnquiry::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Inspection enquiry submitted successfully.',
                'data'    => $enquiry,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function show($id)
    {
        $enquiry = InspectionEnquiry::with(['brand:id,name', 'vehicleModel:id,name', 'inspector'])->findOrFail($id);

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
    public function unassignInspector(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:inspection_enquiries,id',
        ]);

        $enquiry = InspectionEnquiry::find($request->enquiry_id);

        if (!$enquiry->inspector_id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No inspector is assigned to this enquiry.',
            ], 422);
        }

        // Unassign inspector
        $enquiry->inspector_id = null;
        $enquiry->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Inspector unassigned successfully.',
            'data'    => $enquiry->load('inspector'),
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
