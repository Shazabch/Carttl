<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    public function index()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);
        }

        $notifications = $user->notifications()->latest()->take(10)->get();

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

   
    public function destroy($id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 401);
        }

        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
        }

        $notification->delete();

        return response()->json(['status' => 'success', 'message' => 'Notification deleted successfully.']);
    }

    public function markAsRead($id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 401);
        }

        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
        }

        $notification->markAsRead();

        return response()->json(['status' => 'success', 'message' => 'Notification marked as read.']);
    }

    public function clearAll()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 401);
        }

        $user->notifications()->delete();

        return response()->json(['status' => 'success', 'message' => 'All notifications cleared.']);
    }
}
