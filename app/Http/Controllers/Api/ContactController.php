<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Models\User;
use App\Notifications\EnquirySubmitNotification;
use App\Notifications\EnquiryReceivedConfirmation;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'message'      => 'required|string|max:2000',
            'terms_agreed' => 'required|boolean',
        ]);

        try {
          
            $enquiry = ContactSubmission::create($validated);

          
            $recipients = User::role(['admin', 'super-admin'])->get();
            Notification::send($recipients, new EnquirySubmitNotification($enquiry));

           
            Notification::route('mail', $enquiry->email)
                ->notify(new EnquiryReceivedConfirmation($enquiry));

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you! Your enquiry has been received.',
                'data' => $enquiry,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
}
