<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function getUserBiddings()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $bids = VehicleBid::where('user_id', $user->id)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bids,
        ]);
    }

    public function getPurchaseEnquiries()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $enquiries = VehicleEnquiry::where('user_id', $user->id)
            ->where('type', 'purchase')
            ->with([
                'brand:id,name,image_source',
                'vehicleModel:id,name'
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }


    public function getSaleEnquiries()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $enquiries = VehicleEnquiry::where('user_id', $user->id)
            ->where('type', 'sale')
            ->with([
                'brand:id,name,image_source',
                'vehicleModel:id,name'
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $enquiries,
        ]);
    }


    public function getInspectionReports()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated user.'
            ], 401);
        }

        $inspections = InspectionEnquiry::where('user_id', $user->id)
            ->with([
                'brand:id,name,image_source',
                'vehicleModel:id,name'
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $inspections,
        ]);
    }
}
