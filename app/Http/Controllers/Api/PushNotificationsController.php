<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PushNotificationsController extends Controller
{
    protected FCMService $fcm;

    public function __construct(FCMService $fcm)
    {
        $this->fcm = $fcm;
    }

    /**
     * Save FCM device token
     */
    public function saveToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string|unique:device_tokens,device_token',
        ]);

        DeviceToken::updateOrCreate(
            ['device_token' => $request->device_token],
            ['user_id' => auth()->id() ?? null]
        );

        return response()->json([
            'message' => 'Device token saved successfully'
        ]);
    }

    /**
     * Send push notification to a single device
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array'
        ]);

        try {
            $response = $this->fcm->sendNotification(
                $request->device_token,
                $request->title,
                $request->body,
                $request->data ?? []
            );

            return response()->json([
                'success' => true,
                'response' => $response
            ]);

        } catch (\Throwable $e) {
            Log::error('FCM Send Error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send push notification to all users
     */
    public function sendToAll(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array'
        ]);

        $tokens = DeviceToken::pluck('device_token')->toArray();

        if (empty($tokens)) {
            return response()->json([
                'success' => false,
                'message' => 'No device tokens found'
            ], 404);
        }

        $failed = [];
        foreach ($tokens as $token) {
            try {
                $this->fcm->sendNotification(
                    $token,
                    $request->title,
                    $request->body,
                    $request->data ?? []
                );
            } catch (\Throwable $e) {
                Log::error("Failed to send FCM to {$token}: ".$e->getMessage());
                $failed[] = $token;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifications sent',
            'failed_tokens' => $failed
        ]);
    }
}
