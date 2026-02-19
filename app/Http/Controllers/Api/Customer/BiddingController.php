<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\Vehicle;
use App\Models\VehicleBid;
use App\Services\AutoBiddingService;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BiddingController extends Controller
{
    protected FCMService $fcm;

    public function __construct(FCMService $fcm)
    {
        $this->fcm = $fcm;
    }

    public function getVehicleBids($vehicleId)
    {


        $vehicle = Vehicle::findOrFail($vehicleId);

        $totalBids = VehicleBid::where('vehicle_id', $vehicle->id)->count();
        $highestBid = VehicleBid::where('vehicle_id', $vehicle->id)->max('bid_amount') ?? 0;

        $bids = VehicleBid::with('user:id,name')
            ->where('vehicle_id', $vehicle->id)
            ->latest()
            ->take(3)
            ->get();

        $increment = ($vehicle->bid_control > 0)
            ? $vehicle->bid_control
            : 1;

        $minimumNextBid = $highestBid > 0
            ? $highestBid + $increment
            : $vehicle->starting_bid_amount ?? 0;

        return response()->json([
            'status' => 'success',
            'data' => [
                'vehicle' => $vehicle,
                'total_bids' => $totalBids,
                'highest_bid' => $highestBid,
                'bids' => $bids,
                'minimum_next_bid' => $minimumNextBid,
            ]
        ]);
    }


    public function placeBid(Request $request, $vehicleId)
    {

        $request->validate([
            'current_bid' => 'required|numeric|min:1',
            'max_bid' => 'required|numeric|min:1',
            'is_auto' => 'sometimes|boolean',
        ]);

        $vehicle = Vehicle::findOrFail($vehicleId);

        $highestBid = VehicleBid::where('vehicle_id', $vehicle->id)->max('bid_amount') ?? 0;
        $increment = ($vehicle->bid_control > 0)
            ? $vehicle->bid_control
            : 1;


        $minimumNextBid = $highestBid > 0
            ? $highestBid + $increment
            : $vehicle->starting_bid_amount ?? 0;


        if ($request->current_bid < $minimumNextBid) {
            return response()->json([
                'status' => 'error',
                'message' => "Your bid must be at least " . number_format($minimumNextBid),
            ], 422);
        }

        try {
            $bid = VehicleBid::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => Auth::id(),
                'bid_amount' => $request->current_bid,
                'max_bid' => $request->max_bid,
            ]);

            // Send push notification to previous bidder
            $previousBid = VehicleBid::where('vehicle_id', $vehicle->id)
                ->where('id', '!=', $bid->id)
                ->orderBy('bid_amount', 'desc')
                ->first();

            if ($previousBid && $previousBid->user) {
                $deviceTokens = DeviceToken::where('user_id', $previousBid->user->id)
                    ->pluck('device_token')
                    ->toArray();

                foreach ($deviceTokens as $token) {
                    try {
                        $this->fcm->sendNotification(
                            $token,
                            'You\'ve Been Outbid',
                            "A higher bid of AED" . number_format($request->current_bid) . " has been placed on " . $vehicle->title,
                            [
                                'vehicle_id' => $vehicle->id,
                                'bid_id' => $bid->id,
                                'new_bid_amount' => $request->current_bid,
                                'type' => 'outbid'
                            ]
                        );
                    } catch (\Throwable $e) {
                        Log::error("Failed to send outbid notification: " . $e->getMessage());
                    }
                }
            }

            // Trigger auto-bidding process for this vehicle
            $autoBiddingService = app(AutoBiddingService::class);
            $autoBiddingService->processAutoBidsForVehicle($vehicle->id);

            $isAutoBid = false;
            if ($request->is_auto == true) {
                $isAutoBid = true;
            }

            return response()->json([
                'status' => 'success',
                'message' => $isAutoBid ? 'Auto Bid placed successfully.' : 'Bid Placed Successfully',
                'auto_bid' => $isAutoBid,
                'data' => $bid,
            ]);
        } catch (\Exception $e) {
            Log::error('Bid placement failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }
    public function getBidHistory($vehicleId)
    {
        $bids = VehicleBid::with('user:id,name')
            ->where('vehicle_id', $vehicleId)
            ->orderBy('bid_amount', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bids,
        ]);
    }
}
