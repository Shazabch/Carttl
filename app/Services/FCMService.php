<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use GuzzleHttp\Client;

class FCMService
{
    protected $messaging;

    public function __construct()
    {
        // Disable SSL verification for Windows dev
        $guzzle = new Client(['verify' => false]);

        $credentials = config('services.firebase.service_account');

        if (!$credentials) {
            throw new \Exception("Firebase credentials not configured. Please set FIREBASE_CREDENTIALS in .env file.");
        }

        // Support multiple credential formats
        if (is_array($credentials)) {
            // Already an array (from config)
            $factory = (new Factory())->withServiceAccount($credentials);
        } elseif (is_string($credentials)) {
            // Check if it's a file path first (most common case)
            if (file_exists($credentials)) {
                if (!is_readable($credentials)) {
                    throw new \Exception("Firebase credentials file exists but is not readable: {$credentials}. Check file permissions.");
                }
                $factory = (new Factory())->withServiceAccount($credentials);
            } else {
                // Not a file, try parsing as JSON string
                $decoded = json_decode($credentials, true);
                if ($decoded && json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $factory = (new Factory())->withServiceAccount($decoded);
                } else {
                    throw new \Exception("Firebase credentials invalid. Not a valid file path or JSON string: {$credentials}");
                }
            }
        } else {
            throw new \Exception("Firebase credentials must be a file path, JSON string, or array.");
        }

        // Only set client if your version supports it
        if (method_exists($factory, 'withHttpClient')) {
            $factory = $factory->withHttpClient($guzzle);
        }

        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        return $this->messaging->send($message);
    }
}
