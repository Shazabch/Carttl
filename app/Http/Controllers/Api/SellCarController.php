<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleEnquiry;
use App\Models\SaleEnquiryImage;
use App\Models\User;
use App\Models\Brand;
use App\Models\VehicleModel;
use App\Notifications\AccountCreatedConfirmation;
use App\Notifications\VehicleEnquiryNotification;
use App\Notifications\VehicleEnquiryReceivedConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SellCarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|min:10|max:20',
            'email'         => 'required|email',
            'brand_id'      => 'required|exists:brands,id',
            'make_id'       => 'required|exists:vehicle_models,id',
            'year'          => 'required',
            'mileage'       => 'required',
            'specification' => 'required',
            'notes'         => 'nullable',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

       
        $user = null;

        if (auth('api')->check()) {
            $user = auth('api')->user();
        } else {
            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                $tempPassword = Str::random(10);
                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'role'     => 'customer',
                    'password' => Hash::make($tempPassword),
                ]);

                Notification::send($user, new AccountCreatedConfirmation($user, $tempPassword));
                $user->syncRoles('customer');
            }
        }

       
        $enquiry = VehicleEnquiry::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'brand_id'      => $validated['brand_id'],
            'make_id'       => $validated['make_id'],
            'year'          => $validated['year'],
            'mileage'       => $validated['mileage'],
            'specification' => $validated['specification'],
            'notes'         => $validated['notes'] ?? null,
            'type'          => 'sale',
            'user_id'       => $user->id ?? null,
        ]);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $index => $image) {
                $imagePaths['image' . ($index + 1)] = $image->store('sale-enquiries', 'public');
            }

            SaleEnquiryImage::create(array_merge(
                ['sale_enquiry_id' => $enquiry->id],
                $imagePaths
            ));
        }

      
        $recipients = User::role(['admin', 'super-admin'], 'web')->get();
        Notification::send($recipients, new VehicleEnquiryNotification($enquiry));

        if ($user) {
            Notification::send($user, new VehicleEnquiryReceivedConfirmation($enquiry));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sell enquiry submitted successfully.',
            'data' => $enquiry
        ]);
    }
}
