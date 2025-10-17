<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
      public function index()
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
}
