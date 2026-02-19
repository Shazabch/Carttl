<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use App\Services\PackageInvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Check if pending unverified user exists with same email + phone
        $pendingUser = User::where('email', $request->email)
            ->where('phone', $request->phone)
            ->where('phone_verified_at', null)
            ->first();

        if ($pendingUser) {
            // Resend OTP to existing pending user
            $otp = (string) random_int(100000, 999999);
            $otpExpiresAt = now()->addMinutes(2);

            try {
                $twilio = new Client(
                    config('services.twilio.sid'),
                    config('services.twilio.token')
                );

                $twilio->messages->create($pendingUser->phone, [
                    'from' => config('services.twilio.from'),
                    'body' => "Your verification code is {$otp}. It expires in 2 minutes.",
                ]);
            } catch (\Throwable $exception) {
                Log::error('Twilio OTP resend failed for pending user', [
                    'user_id' => $pendingUser->id,
                    'phone' => $pendingUser->phone,
                    'error' => $exception->getMessage(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to send OTP. Please try again later.',
                ], 500);
            }

            // Update pending user with new OTP
            $pendingUser->phone_otp_hash = Hash::make($otp);
            $pendingUser->phone_otp_expires_at = $otpExpiresAt;
            $pendingUser->save();

            return response()->json([
                'status' => 'success',
                'message' => 'OTP resent to your phone. Please verify to continue.',
                'otp_expires_at' => $otpExpiresAt,
                'user' => $pendingUser,
            ]);
        }

        // Normal registration validation
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:6',
            'package_id' => 'required|exists:packages,id',
            'phone'      => 'required|string|max:20|unique:users',
        ]);

        $otp = (string) random_int(100000, 999999);
        $otpExpiresAt = now()->addMinutes(2);

        // Send OTP BEFORE creating user to prevent orphaned records
        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $twilio->messages->create($request->phone, [
                'from' => config('services.twilio.from'),
                'body' => "Your verification code is {$otp}. It expires in 2 minutes.",
            ]);
        } catch (\Throwable $exception) {
            Log::error('Twilio OTP send failed', [
                'phone' => $request->phone,
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send OTP. Please try again later.',
            ], 500);
        }

        // Create user only after OTP is successfully sent
        $user = DB::transaction(function () use ($request, $otp, $otpExpiresAt) {
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'package_id' => $request->package_id,
                'phone'      => $request->phone,
                'password'   => Hash::make($request->password),
                'status'     => 'pending',
            ]);

            $user->phone_otp_hash = Hash::make($otp);
            $user->phone_otp_expires_at = $otpExpiresAt;
            $user->phone_verified_at = null;
            $user->save();

            return $user;
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP sent to your phone. Please verify to continue.',
            'otp_expires_at' => $otpExpiresAt,
            'user' => $user,
        ]);
    }

    public function cleanupPendingUsers(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        // Delete pending unverified users (not verified within 10 minutes)
        $deleted = User::where('email', $request->email)
            ->where('phone', $request->phone)
            ->where('phone_verified_at', null)
            ->where('created_at', '<', now()->subMinutes(10))
            ->delete();

        if ($deleted > 0) {
            Log::info("Cleaned up {$deleted} pending user(s) for email: {$request->email}");
            return response()->json([
                'status' => 'success',
                'message' => 'Pending registration cleaned up. Please register again.',
                'cleaned' => $deleted,
            ]);
        }

        return response()->json([
            'status' => 'info',
            'message' => 'No pending registrations to cleanup.',
        ]);
    }

    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'otp'   => 'required|string|size:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found for this phone number.',
            ], 404);
        }

        if ($user->phone_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone number is already verified.',
            ], 400);
        }
        if (!$user->phone_otp_hash || !$user->phone_otp_expires_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'No OTP found for this phone number. Please request a new one.',
            ], 400);
        }
        if (now()->greaterThan($user->phone_otp_expires_at)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.',
            ], 400);
        }
        if (!Hash::check($request->otp, $user->phone_otp_hash)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP. Please try again.',
            ], 400);
        }


        $user->phone_verified_at = now();
        $user->phone_otp_hash = null;
        $user->phone_otp_expires_at = null;
        $user->save();

        $pdfLink = null;
        $existingInvoice = Invoice::where('type', 'package')
            ->where('user_id', $user->id)
            ->first();

        if ($existingInvoice) {
            $pdfLink = $existingInvoice->pdf_link;
        } else {
            $pdfLink = PackageInvoiceService::generate($user->id);
            Invoice::create([
                'type'     => 'package',
                'user_id'  => $user->id,
                'pdf_link' => $pdfLink,
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Phone verified successfully.',
            'token' => $token,
            'invoice' => $pdfLink,
            'user' => $user,
        ]);
    }

  

    public function resendPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found for this phone number.',
            ], 404);
        }

        if ($user->phone_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone number is already verified.',
            ], 400);
        }

        $otp = (string) random_int(100000, 999999);
        $otpExpiresAt = now()->addMinutes(2);

        $user->phone_otp_hash = Hash::make($otp);
        $user->phone_otp_expires_at = $otpExpiresAt;
        $user->save();

        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $twilio->messages->create($user->phone, [
                'from' => config('services.twilio.from'),
                'body' => "Your verification code is {$otp}. It expires in 2 minutes.",
            ]);
        } catch (\Throwable $exception) {
            Log::error('Twilio OTP resend failed', [
                'user_id' => $user->id,
                'phone' => $user->phone,
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to resend OTP. Please try again later.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP resent to your phone. Please verify to continue.',
            'otp_expires_at' => $otpExpiresAt,
        ]);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token);
    }





    public function logout()
    {
        auth('api')->logout();
        return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    protected function respondWithToken($token)
    {
        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id'            => $user->id,
                'agent_id'      => $user->agent_id,
                'is_approved'   => $user->is_approved,
                'name'          => $user->name,
                'email_verified_at'     => $user->email_verified_at,
                'created_at'     => $user->created_at,
                'updated_at'     => $user->updated_at,
                'email'         => $user->email,
                'target'         => $user->target,
                'bio'         => $user->bio,
                'phone'          => $user->phone,
                'photo' => $user->photo ? asset('storage/' . $user->photo) : null,
                'roles'         => $user->getRoleNames(),
                'permissions'   => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }
}
