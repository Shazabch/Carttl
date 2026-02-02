<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoBiddingService;
use Illuminate\Support\Facades\Log;

class ProcessAutoBids extends Command
{
    protected $signature = 'process:auto-bids';
    protected $description = 'Process automatic bids for vehicle auctions based on max_bid limits';

    public function handle(AutoBiddingService $autoBiddingService)
    {
        Log::info('ProcessAutoBids command started at ' . now());
        
        $result = $autoBiddingService->processAllAutoBids();

        if ($result['processed'] === 0) {
            $this->info('No active auctions to process.');
            Log::info('No active auctions to process');
            return 0;
        }

        $this->info("Auto-bids processed: {$result['processed']} vehicles, {$result['errors']} errors.");
        Log::info("ProcessAutoBids completed. Processed: {$result['processed']}, Errors: {$result['errors']}");

        return 0;
    }
}
