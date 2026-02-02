<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\VehicleBid;
use App\Notifications\AutoBidPlacedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AutoBiddingService
{
    /**
     * Process auto-bids for a specific vehicle
     * 
     * @param int $vehicleId
     * @return void
     */
    public function processAutoBidsForVehicle($vehicleId)
    {
        
        try {
            DB::transaction(function () use ($vehicleId) {
                // Lock the vehicle for update to prevent race conditions
                $vehicle = Vehicle::lockForUpdate()->find($vehicleId);
                
                if (!$vehicle) {
                    return;
                }

                // Get the latest highest bid for this vehicle
                $latestBid = $vehicle->bids()
                    ->lockForUpdate()
                    ->latest('bid_amount')
                    ->first();

                // Skip if no bids exist yet
                if (!$latestBid) {
                    return;
                }

                // Keep iterating until no more auto-bids can be placed
                $keepBidding = true;
                $maxIterations = 100; // Safety limit to prevent infinite loops
                $iteration = 0;

                while ($keepBidding && $iteration < $maxIterations) {
                    $iteration++;
                    $keepBidding = false;

                    // Get the current highest bid and bidder
                    $currentHighestBidder = VehicleBid::where('vehicle_id', $vehicle->id)
                        ->lockForUpdate()
                        ->latest('bid_amount')
                        ->first();

                    if (!$currentHighestBidder) {
                        break;
                    }

                    $currentHighestBid = $currentHighestBidder->bid_amount;
                    $bidIncrement = $vehicle->bid_control ?? 500;
                    if ($bidIncrement <= 0) {
                        $bidIncrement = 500;
                    }

                    // Get all candidates who can still bid (max_bid > current highest bid)
                    $autoBidCandidates = VehicleBid::where('vehicle_id', $vehicle->id)
                        ->where('user_id', '!=', $currentHighestBidder->user_id)
                        ->whereNotNull('max_bid')
                        ->where('max_bid', '>', $currentHighestBid)
                        ->lockForUpdate()
                        ->latest('max_bid')
                        ->get();

                    // Process each candidate
                    foreach ($autoBidCandidates as $candidate) {
                        // Get this candidate's highest bid so far
                        $candidateHighestBid = VehicleBid::where('vehicle_id', $vehicle->id)
                            ->where('user_id', $candidate->user_id)
                            ->max('bid_amount') ?? 0;

                        // Skip if candidate has already reached their max_bid
                        if ($candidateHighestBid >= $candidate->max_bid) {
                            continue;
                        }

                        // Skip if candidate's max_bid doesn't exceed current highest bid
                        if ($candidate->max_bid <= $currentHighestBid) {
                            continue;
                        }

                        // Calculate the auto-bid amount
                        // Auto bid = min(max_bid, competing_bid + bid_control)
                        $autoBidAmount = min($candidate->max_bid, $currentHighestBid + $bidIncrement);

                        // Only place the auto-bid if it's higher than the candidate's previous bids
                        if ($autoBidAmount > $candidateHighestBid) {
                            // Check if we already have an auto-bid from this user at this amount to avoid duplicates
                            $existingAutoBid = VehicleBid::where('vehicle_id', $vehicle->id)
                                ->where('user_id', $candidate->user_id)
                                ->where('bid_amount', $autoBidAmount)
                                ->lockForUpdate()
                                ->exists();

                            if (!$existingAutoBid) {
                                $newBid = VehicleBid::create([
                                    'vehicle_id' => $vehicle->id,
                                    'user_id' => $candidate->user_id,
                                    'bid_amount' => $autoBidAmount,
                                    'max_bid' => $candidate->max_bid,
                                    'is_auto' => true,
                                ]);

                                Log::info("Auto-bid placed for vehicle {$vehicle->id}, user {$candidate->user_id}, amount: {$autoBidAmount}");
                                
                                // Send email notification to user
                                try {
                                    if ($newBid->user) {
                                        $newBid->user->notify(new AutoBidPlacedNotification($newBid, $vehicle));
                                        Log::info("Auto-bid notification sent to user {$candidate->user_id}");
                                    }
                                } catch (\Exception $e) {
                                    Log::error("Failed to send auto-bid notification to user {$candidate->user_id}: " . $e->getMessage());
                                }
                                
                                $keepBidding = true; // Continue bidding since we just placed a new bid
                            }
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error("Error processing auto-bids for vehicle {$vehicleId}: " . $e->getMessage());
        }
    }

    /**
     * Process auto-bids for all active auctions
     * Used by the scheduled command
     * 
     * @return array Returns array with 'processed' and 'errors' count
     */
    public function processAllAutoBids()
    {
        $processed = 0;
        $skipped = 0;

        // Get all active auction vehicles that haven't ended
        $vehicles = Vehicle::where('is_auction', 1)
            ->where(function ($query) {
                $query->whereNull('auction_end_date')
                    ->orWhere('auction_end_date', '>', now());
            })
            ->get();

        foreach ($vehicles as $vehicle) {
            try {
                $this->processAutoBidsForVehicle($vehicle->id);
                $processed++;
            } catch (\Exception $e) {
                $skipped++;
                Log::error("Error processing auto-bids for vehicle {$vehicle->id}: " . $e->getMessage());
            }
        }

        return [
            'processed' => $processed,
            'errors' => $skipped,
        ];
    }
}
