<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactSubmission;
use App\Models\InspectionEnquiry;
use App\Models\VehicleBid;
use App\Models\VehicleEnquiry;
use App\Models\VehicleInspectionReport;
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

    $status = $request->input('status'); // nullable
    $search = $request->input('search'); // nullable
    $vehicleId = $request->input('vehicle_id'); // optional filter
    $perPage = $request->input('per_page'); // nullable

    $query = VehicleBid::where('user_id', $user->id)
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($vehicleId, function ($query) use ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        })
        ->when($search, function ($query) use ($search) {
            $query->whereHas('vehicle', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('vin', 'like', "%{$search}%");
            });
        })
        ->with([
            'vehicle.brand:id,name,image_source',
            'vehicle.vehicleModel:id,name'
        ]);

    // Return paginated results if per_page is set, else return all
    $bids = $perPage ? $query->paginate($perPage) : $query->get();

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
                'vehicleModel:id,name',
                'inspectionReports' => function ($q) {
                    $q->with([
                        'vehicle',
                        'damages',
                        'inspector',
                        'images',
                        'brand:id,name',
                        'vehicleModel:id,name',
                        'fields.files'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Add make_name and model_name for each report
        $appointments->getCollection()->transform(function ($appointment) {
            if ($appointment->inspectionReports) {
                $appointment->inspectionReports->transform(function ($report) {
                    $report->make_name = $report->brand->name ?? null;
                    $report->model_name = $report->vehicleModel->name ?? null;
                    unset($report->brand, $report->vehicleModel);
                    return $report;
                });
            }
            return $appointment;
        });

        return response()->json([
            'status' => 'success',
            'data' => $appointments,
        ]);
    }


    public function getInspectionReportByEnquiry(Request $request, $inspectionEnquiryId)
    {
        $report = VehicleInspectionReport::where('inspection_enquiry_id', $inspectionEnquiryId)
            ->with([
                'vehicle',
                'damages',
                'inspector',
                'images',
                'brand:id,name',
                'vehicleModel:id,name',
                'fields.files'
            ])
            ->first();

        if (!$report) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inspection report not found for this enquiry.'
            ], 404);
        }

        // Add make_name and model_name like in show()
        $report->make_name = $report->brand->name ?? null;
        $report->model_name = $report->vehicleModel->name ?? null;

        unset($report->brand, $report->vehicleModel);

        return response()->json([
            'status' => 'success',
            'data'   => $report,
        ]);
    }


    public function getInspectionReportByVehicle(Request $request, $vehicleId)
    {
        $report = VehicleInspectionReport::where('vehicle_id', $vehicleId)
            ->with([
                'vehicle',
                'damages',
                'inspector',
                'images',
                'brand:id,name',
                'vehicleModel:id,name',
                'fields.files'
            ])
            ->first();

        if (!$report) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inspection report not found for this vehicle.'
            ], 404);
        }

        // Add make_name and model_name for convenience
        $report->make_name = $report->brand->name ?? null;
        $report->model_name = $report->vehicleModel->name ?? null;

        unset($report->brand, $report->vehicleModel);

        return response()->json([
            'status' => 'success',
            'data' => $report,
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
