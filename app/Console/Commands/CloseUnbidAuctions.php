<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CloseUnbidAuctions extends Command
{
    protected $signature = 'auctions:close-unbid';
    protected $description = 'Close auctions with no bids after auction end date';

    public function handle()
    {
        $now = Carbon::now();

        $vehicles = Vehicle::where('is_auction', 1)
            ->where('auction_end_date', '<', $now)
            ->whereDoesntHave('bids')
            ->get();
        if ($vehicles->isEmpty()) {
            $this->info('No unbid auctions to close.');
            Log::info('No unbid auctions to close at ' . $now);
            return 0;
        }

        $count = $vehicles->count();

        // Update auctions
        Vehicle::whereIn('id', $vehicles->pluck('id'))->update(['is_auction' => 0]);

        $this->info("Closed {$count} auctions with no bids.");

        // Log each closed auction in laravel.log
        foreach ($vehicles as $vehicle) {
            Log::info("Auction closed automatically for vehicle ID: {$vehicle->id}, no bids received at {$now}");
        }

        return 0;
    }
}
