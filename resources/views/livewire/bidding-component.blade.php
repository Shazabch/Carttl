<div>
    <div class="auction-card">
        <div class="auction-header d-flex justify-content-between align-items-center mb-3">
            <div class="div">
                <p class="auction-id mb-1">#AU-2024-0156</p>
                <h3>{{$selected_vehicle->title}}</h3>
            </div>

        </div>

        <div class="car-subtitle">
            @foreach($tags as $feature)
            <span class="badge-custom">{{$feature->name}}</span>
            @endforeach
        </div>

        <div class="current-bid d-flex justify-content-between align-items-center mb-3">
            <div class="div">
                <span class="bid-label mb-0">Current Bid</span>
                <span class="bid-amount">{{format_currency($highestBid)}}</span>

            </div>
            <div class="div">
                <span class="bid-label mb-0">Starting Bid</span>
                <span class="bid-amount">{{format_currency($selected_vehicle->starting_bid_amount)}}</span>
            </div>
        </div>
        <div class="current-bid">
            <span class="bid-count">{{$totalBids}} bids</span>
        </div>
        <div class="action-buttons mb-2">

             <livewire:favorite-button-detail-component :vehicleId="$selected_vehicle->id" />

            <button class="btn-icon" data-bs-toggle="tooltip" title="Share">
                <i class="fas fa-share-alt"></i>
            </button>
            <button class="btn-icon" data-bs-toggle="tooltip" title="Print">
                <i class="fas fa-print"></i>
            </button>
        </div>
        <div class="auction-header">

            <div class="auction-timer  d-flex justify-content-center gap-3 align-items-end mb-3">
                <div class="px-3 py-2 d-flex gap-2">
                    <div class="badge-custom p-3">
                        <span id="hours" class="fw-bold">00</span><small> h</small>
                    </div>
                    <span>:</span>
                    <div class="badge-custom p-3">
                        <span id="minutes" class="fw-bold">00</span><small> m</small>
                    </div>
                    <span>:</span>
                    <div class="badge-custom p-3">
                        <span id="seconds" class="fw-bold">00</span><small> s</small>
                    </div>
                </div>
            </div>
        </div>

        @if($bids->count() > 0)
        <div class="bid-history">
            @foreach($bids as $bid)
            <div class="bid-item">
                <span class="bidder">{{ $bid->user->name }}</span>
                <span class="bid-amount">{{ format_currency($bid->bid_amount) }}</span>
                <span class="bid-time">{{ \Carbon\Carbon::parse($bid->created_at)->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
        @endif
        <div class="bid-actions">
            <div class="bid-input-group">
                <input type="number" wire:model="current_bid" class="form-control bid-input"
                    placeholder="Enter bid ">
                @error('current_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <span class="input-addon">AED</span>
            </div>
            <div class="bid-input-group">
                <input type="number" wire:model="max_bid" class="form-control bid-input"
                    placeholder="Enter Max Bid">
                @error('max_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <span class="input-addon">AED</span>
            </div>
            @if(auth()->id())
            <button wire:click="saveBid" class="btn btn-primary btn-bid">
                <i class="fas fa-gavel"></i>
                Place Bid <span wire:loading wire:target="saveBid">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </span>
            </button>
            @else
            <a href="/login" class="btn btn-primary btn-bid">
                <i class="fas fa-gavel"></i>
                Signin & Place Bid <div class="spinner"></div>
            </a>
            @endif
            <!-- <button class="btn btn-outline-primary btn-auto-bid">
                                        <i class="fas fa-robot"></i>
                                        Auto Bid
                                    </button> -->
        </div>
        <div class="auction-details">
            <div class="detail-row">
                <span>Reserve:</span>
                <span class="text-success">Met</span>
            </div>
            <div class="detail-row">
                <span>Ends:</span>
                <span>Ends In {{ \Carbon\Carbon::parse($selected_vehicle->auction_end_date)->format('M d, Y \a\t g:i A') }}</span>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get auction end time from backend
            const auctionEndTime = new Date("{{ \Carbon\Carbon::parse($selected_vehicle->auction_end_date)->format('Y-m-d H:i:s') }}").getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = auctionEndTime - now;

                if (distance <= 0) {
                    document.getElementById("auctionTimer").innerHTML = "Auction Ended";
                    clearInterval(timerInterval);
                    return;
                }

                // Time calculations
                const hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

                // Display
                document.getElementById("hours").textContent = hours;
                document.getElementById("minutes").textContent = minutes;
                document.getElementById("seconds").textContent = seconds;
            }

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        });
    </script>

</div>