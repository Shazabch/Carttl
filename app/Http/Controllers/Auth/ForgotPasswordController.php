<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('role', 'customer')->where('email', $request->email)->first();
        if (!$user) {
            return back()->with(['error' => 'We can\'t find a user with that email address.']);
        }

        // Generate token
        $token = Str::random(64);

        // Save token in password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Send email

        $resetLink = URL::temporarySignedRoute(
            'password.reset', // Route name
            now()->addMinutes(60), // Expiration time
            ['token' => $token, 'email' => $request->email] // Params
        );
        Mail::raw("We received a request to reset your password for your account. 
If you made this request, please click the link below to reset your password. 
If you didn’t request a password reset, you can safely ignore this email.

Reset Password Link: $resetLink

This link will expire in 60 minutes.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset Request');
        });

        return back()->with('success', 'We have emailed your password reset link!');
    }
}
