<div>
    <div>
        <div class="auction-card">
            <div class="auction-header d-flex justify-content-between align-items-center mb-3">
                <div class="div">
                    <p class="auction-id mb-1">#AU-2024-0156</p>
                    <h3 class="title-line-clamp-2">{{$selected_vehicle->title}}</h3>
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

            <!-- I've added an ID here to make it easier to target from the script -->
            <!-- === START: IMPROVED TIMER UI === -->
            <div id="auctionTimerContainer" class="timer-card mb-4">
                <h3 class="p-22 fw-600 text-detail-primary mb-3">Auction Ends In</h3>
                <div class="timer-wrapper">
                    <div class="timer-segment">
                        <span id="hours" class="timer-number">00</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-segment">
                        <span id="minutes" class="timer-number">00</span>
                        <span class="timer-label">Minutes</span>
                    </div>
                    <span class="timer-separator">:</span>
                    <div class="timer-segment">
                        <span id="seconds" class="timer-number">00</span>
                        <span class="timer-label">Seconds</span>
                    </div>
                </div>
            </div>


            <!-- === END: IMPROVED TIMER UI === -->
            @if($bids->count() > 0)
            <div class="bid-history">
                <h3 class="p-22 fw-600 text-detail-primary">Bid History</h3>
                @foreach($bids as $bid)
                <div class="bid-item">
                    <div class="bid-top">
                        <span class="bidder">********</span>
                        <span class="bid-amount">{{ format_currency($bid->bid_amount) }}</span>
                    </div>
                    <span class="bid-time">{{ \Carbon\Carbon::parse($bid->created_at)->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
            @endif
            <div class="bid-actions">
                <div class="bid-input-group">
                    <input type="number" wire:model.live="current_bid" class="form-control bid-input"
                        placeholder="Enter bid " step="500" @if($is_not_login) disabled @endif min="{{$current_bid}}">
                    @error('current_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    <span class="input-addon">AED</span>
                </div>
                <div class="bid-input-group">
                    <input type="number" wire:model.live="max_bid" class="form-control bid-input"
                        placeholder="Enter Max Bid" min="{{$max_bid}}" step="500" @if($is_not_login) disabled @endif>
                    @error('max_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    <span class="input-addon">AED</span>
                </div>
                @if(auth()->id())
                <button wire:click="saveBid" class="btn btn-primary btn-bid">
                    <i class="fas fa-gavel me-2"></i>
                    Place Bid <span wire:loading wire:target="saveBid">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                </button>
                @else
                <button wire:click="saveBid" class="btn btn-primary btn-bid">
                    <i class="fas fa-gavel me-2"></i>
                    Signin & Place Bid <span wire:loading wire:target="saveBid">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                </button>

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
                const auctionEndTime = new Date("{{ \Carbon\Carbon::parse($selected_vehicle->auction_end_date)->format('Y-m-d H:i:s') }}").getTime();
                const timerTitle = document.getElementById("auctionTimerTitle");

                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = auctionEndTime - now;

                    if (distance <= 0) {
                        // Freeze at 00:00:00
                        document.getElementById("hours").textContent = "00";
                        document.getElementById("minutes").textContent = "00";
                        document.getElementById("seconds").textContent = "00";

                        // Change title
                        timerTitle.textContent = "Auction Ended";

                        clearInterval(timerInterval);
                        return;
                    }

                    const hours = String(Math.floor(distance / (1000 * 60 * 60))).padStart(2, '0');
                    const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

                    document.getElementById("hours").textContent = hours;
                    document.getElementById("minutes").textContent = minutes;
                    document.getElementById("seconds").textContent = seconds;
                }

                const timerInterval = setInterval(updateTimer, 1000);
                updateTimer();
            });
        </script>


    </div>