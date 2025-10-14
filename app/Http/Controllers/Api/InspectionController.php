<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\InspectionEnquiry;
use App\Models\User;
use App\Models\VehicleModel;
use App\Notifications\AccountCreatedConfirmation;
use App\Notifications\VehicleEnquiryNotification;
use App\Notifications\VehicleInspectionRecievedConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class InspectionController extends Controller
{
   
    public function saveInspection(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:50',
            'email'     => 'required|email|max:255',
            'type'      => 'required|string',
            'date'      => 'required|date',
            'time'      => 'required|string|max:50',
            'location'  => 'required|string|max:255',
            'year'      => 'required|string|max:4',
            'make'      => 'required|integer|exists:brands,id',
            'model'     => 'required|integer|exists:vehicle_models,id',
        ]);

        try {
          
            $user = auth('api')->user();

            if (!$user && $validated['email']) {
                $user = User::where('email', $validated['email'])->first();

                if (!$user) {
                    $tempPassword = Str::random(10);

                    $user = User::create([
                        'name'     => $validated['name'] ?: 'Customer',
                        'email'    => $validated['email'],
                        'role'     => 'customer',
                        'password' => Hash::make($tempPassword),
                    ]);

                    $user->syncRoles('customer');
                    Notification::send($user, new AccountCreatedConfirmation($user, $tempPassword));
                }
            }

           
            if ($user) {
                $validated['user_id'] = $user->id;
            }

           
            $validated['type'] = 'inspection';
            $enquiry = InspectionEnquiry::create($validated);

           
            $recipients = User::role(['admin', 'super-admin'])->get();
            Notification::send($recipients, new VehicleEnquiryNotification($enquiry));

            
            if ($user) {
                Notification::send($user, new VehicleInspectionRecievedConfirmation($enquiry));
            }

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
}
