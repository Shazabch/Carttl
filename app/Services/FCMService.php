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

        $credentialsPath = config('firebase.service_account');

        // Support both file path and JSON string
        if ($credentialsPath) {
            // Check if it's a JSON string or file path
            if (is_file($credentialsPath) && is_readable($credentialsPath)) {
                $factory = (new Factory())->withServiceAccount($credentialsPath);
            } elseif (is_string($credentialsPath) && json_decode($credentialsPath, true)) {
                // JSON string provided directly
                $factory = (new Factory())->withServiceAccount(json_decode($credentialsPath, true));
            } else {
                throw new \Exception(
                    "Firebase credentials file not found or not readable at: " . $credentialsPath . 
                    ". Please check FIREBASE_CREDENTIALS in .env and file permissions."
                );
            }
        } else {
            throw new \Exception("Firebase credentials not configured. Please set FIREBASE_CREDENTIALS in .env file.");
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
