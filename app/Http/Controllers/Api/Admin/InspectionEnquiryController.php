<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentStatusHistory;
use Illuminate\Http\Request;
use App\Models\InspectionEnquiry;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Notifications\InspectionStatusChangedNotification;
use App\Services\FCMService;
use Illuminate\Support\Facades\Log;

class InspectionEnquiryController extends Controller
{
   public function index(Request $request)
{
    $user = auth('api')->user();
    $search = $request->get('search', '');

    $dateFrom = $request->get('date_from', $request->get('dateFrom'));
    $dateTo   = $request->get('date_to', $request->get('dateTo'));

    $sortBy  = $request->get('sort_by', 'created_at');
    $sortDir = $request->get('sort_dir', 'DESC');
    $perPage = $request->get('per_page', 10);

    $status = $request->get('status'); // ✅ status filter

    $enquiries = InspectionEnquiry::query()
        ->with([
            'brand:id,name',
            'vehicleModel:id,name',
            'inspector:id,name,email,phone',
            'creator:id,name,email'
        ])

        // Agent role restriction - show enquiries from their assigned customers
        ->when($user && $user->hasRole('agent'), fn($query) =>
            $query->whereHas('user', fn($q) =>
                $q->where('agent_id', $user->id)
            )
        )

        // Date filter
        ->when($dateFrom || $dateTo, function ($query) use ($dateFrom, $dateTo) {
            $query->where(function ($q) use ($dateFrom, $dateTo) {
                $q->whereNotNull('date')
                    ->when($dateFrom && $dateTo, fn($qq) => $qq->whereBetween('date', [$dateFrom, $dateTo]))
                    ->when($dateFrom && !$dateTo, fn($qq) => $qq->whereDate('date', '>=', $dateFrom))
                    ->when(!$dateFrom && $dateTo, fn($qq) => $qq->whereDate('date', '<=', $dateTo));

                $q->orWhere(function ($qq) use ($dateFrom, $dateTo) {
                    $qq->whereNull('date')
                        ->when($dateFrom && $dateTo, fn($qqq) => $qqq->whereBetween('created_at', ["$dateFrom 00:00:00", "$dateTo 23:59:59"]))
                        ->when($dateFrom && !$dateTo, fn($qqq) => $qqq->where('created_at', '>=', "$dateFrom 00:00:00"))
                        ->when(!$dateFrom && $dateTo, fn($qqq) => $qqq->where('created_at', '<=', "$dateTo 23:59:59"));
                });
            });
        })

        // Inspector role restriction
        ->when($user->role === 'inspector', fn($query) =>
            $query->where('inspector_id', $user->id)
        )

        // Search filter
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })

        // ✅ Status filter
        ->when($status !== null && $status !== '', function ($query) use ($status) {
            $query->where('status', $status);
        })

        // Inspector name filter
        ->when($request->filled('inspector'), function ($query) use ($request) {
            $query->whereHas('inspector', fn($q) =>
                $q->where('name', 'like', "%{$request->inspector}%")
            );
        })

        // Created by filter
        ->when($request->filled('created_by'), function ($query) use ($request) {
            $query->whereHas('creator', fn($q) =>
                $q->where('name', 'like', "%{$request->created_by}%")
            );
        })

        ->orderBy($sortBy, $sortDir)
        ->paginate($perPage);

    return response()->json([
        'status' => 'success',
        'data'   => $enquiries,
    ]);
}



    public function enquiryCreators(Request $request)
{
    $search = $request->get('search');

    $creators = User::whereIn('id', function ($query) {
            $query->select('created_by')
                ->from('inspection_enquiries')
                ->whereNotNull('created_by')
                ->groupBy('created_by');
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->orderBy('name')
        ->get(['id', 'name', 'email']);

    return response()->json([
        'status' => 'success',
        'data'   => $creators,
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



    public function createCustomer(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
        ]);

        // Ensure "customer" role exists
        $role = Role::firstOrCreate(['name' => 'customer']);

        // Generate random email
        $email = Str::random(10) . '@example.com';

        // Create customer
        $customer = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $email,
            'password' => Hash::make('password'),
            'role_id'  => $role->id,
        ]);
        $customer->assignRole($role);
        

        return response()->json([
            'message'  => 'Customer created successfully',
            'customer' => $customer
        ], 201);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Validate only name and phone
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $customer->id,
        ]);

        // Do NOT change role – keep existing one

        // Update fields
        $customer->name  = $request->name;
        $customer->phone = $request->phone;

        $customer->save();

        return response()->json([
            'message'  => 'Customer updated successfully',
            'customer' => $customer
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
            'date'           => 'nullable|date',
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
            $validated['date'] = $request->date    ? $request->date
                : now()->format('Y-m-d');
            $validated['time'] = now()->format('H:i');

            // Assign inspector
            $validated['inspector_id'] = $request->inspector_id;
            $validated['created_by'] = auth('api')->id();
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
            'date'           => 'nullable|date',
        ]);

        try {
            if ($request->has('user_id')) {
                $customer = User::findOrFail($request->user_id);

                $validated['name']  = $customer->name;
                $validated['phone'] = $customer->phone;
                $validated['email'] = $customer->email;
                $validated['user_id'] = $customer->id;
            }
            if ($request->has('date')) {
                $validated['date'] = $request->date;
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
            $enquiry = InspectionEnquiry::with('user')->findOrFail($request->enquiry_id);

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

            // Send notification to user
            if ($enquiry->user) {
                try {
                    // Send email and database notification
                    $enquiry->user->notify(new InspectionStatusChangedNotification($enquiry, $request->status, $request->comment));

                    // Send push notification via Firebase
                    $this->sendPushNotification($enquiry, $request->status);
                } catch (\Exception $notificationError) {
                    Log::error("Failed to send notification for enquiry {$enquiry->id}: " . $notificationError->getMessage());
                }
            }

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

    /**
     * Send push notification to user via Firebase Cloud Messaging
     */
    private function sendPushNotification($enquiry, $newStatus)
    {
        try {
            $user = $enquiry->user;
            if (!$user) {
                return;
            }

            // Get user's device tokens
            $deviceTokens = \DB::table('device_tokens')
                ->where('user_id', $user->id)
                ->pluck('device_token')
                ->toArray();

            if (empty($deviceTokens)) {
                Log::info("No device tokens found for user {$user->id}");
                return;
            }

            $fcmService = new FCMService();
            $title = "Appointment Status Updated";
            $vehicleName = $enquiry->year . ' ' . 
                ($enquiry->brand ? $enquiry->brand->name : 'Unknown') . ' ' . 
                ($enquiry->vehicleModel ? $enquiry->vehicleModel->name : 'Unknown');
            
            $body = "Your Appointment for {$vehicleName} is now {$newStatus}";
            $data = [
                'enquiry_id' => (string) $enquiry->id,
                'status' => $newStatus,
                'action' => 'Appointment_status_changed',
            ];

            // Send to all device tokens
            foreach ($deviceTokens as $token) {
                try {
                    $fcmService->sendNotification($token, $title, $body, $data);
                    Log::info("Push notification sent to user {$user->id} for enquiry {$enquiry->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to send push notification to token {$token}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in sendPushNotification: " . $e->getMessage());
        }
    }


    public function show($id)
    {
        $enquiry = InspectionEnquiry::with([
            'brand:id,name',
            'vehicleModel:id,name',
            'inspector',
            'creator:id,name,email',
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
