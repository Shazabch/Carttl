<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentStatusHistory;
use Illuminate\Http\Request;
use App\Models\InspectionEnquiry;
use App\Models\User;

class InspectionEnquiryController extends Controller
{
 public function index(Request $request)
{
    $user = auth('api')->user();
    $search = $request->get('search', '');
    
    // Accept both snake_case and camelCase
    $dateFrom = $request->get('date_from', $request->get('dateFrom'));
    $dateTo   = $request->get('date_to', $request->get('dateTo'));

    $sortBy = $request->get('sort_by', 'created_at');
    $sortDir = $request->get('sort_dir', 'DESC');
    $perPage = $request->get('per_page', 10);

    $enquiries = InspectionEnquiry::query()
        ->with([
            'brand:id,name',
            'vehicleModel:id,name',
            'inspector:id,name,email,phone'
        ])
        // Inclusive date filter
        ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            $query->whereBetween('created_at', [
                $dateFrom . ' 00:00:00', // start of the day
                $dateTo . ' 23:59:59'    // end of the day
            ]);
        })
        ->when($dateFrom && !$dateTo, function ($query) use ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom . ' 00:00:00');
        })
        ->when(!$dateFrom && $dateTo, function ($query) use ($dateTo) {
            $query->where('created_at', '<=', $dateTo . ' 23:59:59');
        })
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
            'type'           => 'required|string',
            'location'       => 'required|string|max:255',
            'year'           => 'required|string|max:4',
            'make'           => 'required|integer|exists:brands,id',
            'model'          => 'required|integer|exists:vehicle_models,id',
            'user_id'        => 'required|integer|exists:users,id',
            'inspector_id'   => 'nullable|integer|exists:users,id',

            // status history fields
            'status'         => 'nullable|string|max:50',
            'comment'        => 'nullable|string',
            

            // other fields
            'comment_initial' => 'nullable|string',
            'asking_price'   => 'nullable|numeric',
            'offer_price'    => 'nullable|numeric',
        ]);

        try {
            // Get customer
            $customer = User::findOrFail($request->user_id);

            // Auto-fill fields from customer
            $validated['name']  = $customer->name;
            $validated['phone'] = $customer->phone;
            $validated['email'] = $customer->email;

            // Auto date & time
            $validated['date'] = now()->toDateString();
            $validated['time'] = now()->format('H:i');

            // Assign inspector
            $validated['inspector_id'] = $request->inspector_id;
            $validated['source'] = "admin";

            // Create enquiry
            $enquiry = InspectionEnquiry::create($validated);

            // Save status history

            AppointmentStatusHistory::create([
                'appointment_id' => $enquiry->id,
                'status'         => $request->status,
                'comment'       => $request->comment,
                'creator'        => auth('api')->id(),
            ]);

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



    public function update(Request $request, $id)
    {
        $enquiry = InspectionEnquiry::findOrFail($id);

        $validated = $request->validate([
            'type'           => 'nullable|string|max:255',
            'location'       => 'nullable|string|max:255',
            'year'           => 'nullable|string|max:4',
            'make'           => 'nullable|integer|exists:brands,id',
            'model'          => 'nullable|integer|exists:vehicle_models,id',
            'user_id'        => 'nullable|integer|exists:users,id',
            'inspector_id'   => 'nullable|integer|exists:users,id',
            'status'         => 'nullable|string|max:50',
            'comment'        => 'nullable|string|max:500',
            'comment_initial' => 'nullable|string|max:500',
            'asking_price'   => 'nullable|numeric',
            'offer_price'  => 'nullable|numeric',
        ]);

        try {
            if ($request->has('user_id')) {
                $customer = User::findOrFail($request->user_id);

                $validated['name']  = $customer->name;
                $validated['phone'] = $customer->phone;
                $validated['email'] = $customer->email;
                $validated['user_id'] = $customer->id;
            }

            if ($request->has('inspector_id')) {
                $validated['inspector_id'] = $request->inspector_id;
            }

            // Preserve type if provided
            if ($request->has('type')) {
                $validated['type'] = $request->type;
            }

            $enquiry->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Inspection enquiry updated successfully.',
                'data'    => $enquiry,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function changeStatus(Request $request)
    {
        $validated = $request->validate([
            'enquiry_id'  => 'required|exists:inspection_enquiries,id',
            'status'      => 'required|string|max:50',
            'comment'     => 'nullable|string',
        ]);

        try {
            $enquiry = InspectionEnquiry::findOrFail($request->enquiry_id);

            // Update status in enquiry
            $enquiry->status = $request->status;
            $enquiry->save();

            // Insert into status history
            AppointmentStatusHistory::create([
                'appointment_id' => $enquiry->id,
                'status'         => $request->status,
                'comment'       => $request->comment,
                'creator'        => auth('api')->id(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Status updated successfully.',
                'data'    => $enquiry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }


   public function show($id)
{
    $enquiry = InspectionEnquiry::with([
        'brand:id,name',
        'vehicleModel:id,name',
        'inspector',
        'statusHistories' => function ($q) {
            $q->select('id', 'appointment_id', 'status', 'comment', 'creator', 'created_at')
              ->with('creatorUser:id,name'); // to show creator name
        }
    ])->findOrFail($id);

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
