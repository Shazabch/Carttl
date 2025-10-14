<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleEnquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AccountCreatedConfirmation;
use App\Notifications\VehicleEnquiryNotification;
use App\Notifications\VehicleEnquiryReceivedConfirmation;
use Illuminate\Support\Str;

class BuyCarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string',
            'phone' => 'required|min:13|max:13',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $user = auth('api')->user();

        if (!$user && $request->email) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $tempPassword = Str::random(10);

                $user = User::create([
                    'name' => $request->name ?: 'Customer',
                    'email' => $request->email,
                    'role' => 'customer',
                    'password' => Hash::make($tempPassword),
                ]);

               
                $user->assignRole('customer');

              
                Notification::send($user, new AccountCreatedConfirmation($user, $tempPassword));
            }
        }

        $enquiry = VehicleEnquiry::create([
            'name'       => $request->name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'address'    => $request->address,
            'user_id'    => $user?->id,
            'type'       => 'purchase',
            'vehicle_id' => $request->vehicle_id,
        ]);

       
        $admins = User::role(['admin', 'super-admin'], 'web')->get();
        Notification::send($admins, new VehicleEnquiryNotification($enquiry));

       
        if ($user) {
            Notification::send($user, new VehicleEnquiryReceivedConfirmation($enquiry));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Buy enquiry submitted successfully.',
            'data' => $enquiry
        ]);
    }
}
