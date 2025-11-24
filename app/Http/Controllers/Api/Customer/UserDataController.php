<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactSubmission;
use App\Models\InspectionEnquiry;
use App\Models\VehicleBid;
use App\Models\VehicleEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDataController extends Controller
{
    public function profile()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated user.'], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated user.'], 401);
        }

        $validated = $request->validate([
            'name'  => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:13',
            'bio'   => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully.',
            'data' => $user
        ]);
    }
    public function changePassword(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated user.'], 401);
        }

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);


        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your current password is incorrect.',
            ], 400);
        }


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your password has been changed successfully!',
        ]);
    }

    public function getUserBiddings(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search = $request->input('search');
        $perPage = $request->input('per_page', 1);

        $bids = VehicleBid::where('user_id', $user->id)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('vehicle', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%");
                });
            })
            ->with(['vehicle.brand:id,name,image_source', 'vehicle.vehicleModel:id,name'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $bids,
        ]);
    }


    public function getPurchaseEnquiries(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $enquiries = VehicleEnquiry::where('user_id', $user->id)
            ->where('type', 'purchase')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('vehicleModel', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->with(['brand:id,name,image_source', 'vehicleModel:id,name'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }
    public function getContactEnquiries(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $email = $user->email;
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $enquiries = ContactSubmission::where('email', $email)
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }


    public function getSaleEnquiries(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $enquiries = VehicleEnquiry::where('user_id', $user->id)
            ->where('type', 'sale')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('vehicleModel', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->with(['brand:id,name,image_source', 'vehicleModel:id,name'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }
    public function getInspectionAppointments(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $appointments = InspectionEnquiry::where('user_id', $user->id)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('vehicleModel', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->with([
                'brand:id,name,image_source',
                'vehicleModel:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $appointments,
        ]);
    }



    public function getInspectionReports(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $inspections = InspectionEnquiry::where('user_id', $user->id)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('vehicleModel', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->with(['brand:id,name,image_source', 'vehicleModel:id,name'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $inspections,
        ]);
    }
    public function getUserBookings(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $bookings = Booking::where('user_id', $user->id)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('vehicle', function ($v) use ($search) {
                    $v->whereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->with([
                'vehicle:id,title,year,brand_id,vehicle_model_id',
                'vehicle.brand:id,name,image_source',
                'vehicle.vehicleModel:id,name',
                'vehicle.images:id,path'
            ])
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $bookings,
        ]);
    }
}
