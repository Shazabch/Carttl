<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BiddingController extends Controller
{
    const BID_INCREMENT = 500;
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

        $minimumNextBid = $highestBid > 0
            ? $highestBid + self::BID_INCREMENT
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
        ]);

        $vehicle = Vehicle::findOrFail($vehicleId);

        $highestBid = VehicleBid::where('vehicle_id', $vehicle->id)->max('bid_amount') ?? 0;
        $minimumNextBid = $highestBid > 0
            ? $highestBid + self::BID_INCREMENT
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

            return response()->json([
                'status' => 'success',
                'message' => 'Bid placed successfully.',
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
