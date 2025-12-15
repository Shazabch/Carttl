<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use App\Services\PackageInvoiceService;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
  public function register(Request $request)
{
    $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|unique:users',
        'password'   => 'required|string|min:6',
        'package_id' => 'required|exists:packages,id',
    ]);

    // Create user
    $user = User::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'package_id' => $request->package_id,
        'password'   => Hash::make($request->password),
    ]);

    // ✅ Generate invoice PDF (NO HTTP)
    $pdfLink = PackageInvoiceService::generate($user->id);

    // Save payment record
    Payment::create([
        'user_id'    => $user->id,
        'package_id' => $request->package_id,
        'pdf_link'   => $pdfLink,
        'status'     => 'pending',
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'status'  => 'success',
        'message' => 'User registered & invoice generated',
        'token'   => $token,
        'pdf_url' => $pdfLink,
        'user'    => $user,
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
