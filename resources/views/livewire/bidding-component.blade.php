<div>
    <div>
        <style>
            .timer-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
                background-color: #f8f9fa;
                /* A light background to frame the timer */
                padding: 20px;
                border-radius: 12px;
                border: 1px solid #e9ecef;
                /* width: fit-content; */
            }

            .timer-segment {
                text-align: center;
                min-width: 80px;
            }

            .timer-number {
                font-size: 2.5rem;
                /* Larger numbers for impact */
                font-weight: 700;
                color: #bd9731 ;
                /* Dark text for readability */
                line-height: 1;
                display: block;
            }

            .timer-label {
                font-size: 0.75rem;
                text-transform: uppercase;
                color: #bd9731;
                /* Muted color for the label */
                letter-spacing: 0.5px;
                margin-top: 5px;
                display: block;
            }

            .timer-separator {
                font-size: 2rem;
                font-weight: 600;
                color: #bd9731 ;
                /* A subtle separator */
                padding-bottom: 25px;
                /* Aligns with the number's baseline */
            }
        </style>
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

            <!-- I've added an ID here to make it easier to target from the script -->
            <!-- === START: IMPROVED TIMER UI === -->
            <div class="timer-wrapper my-4">
                <div class="timer-segment">
                    <span id="hours" class="timer-number">00</span>
                    <span class="timer-label">Hours</span>
                </div>
                <div class="timer-separator">:</div>
                <div class="timer-segment">
                    <span id="minutes" class="timer-number">00</span>
                    <span class="timer-label">Minutes</span>
                </div>
                <div class="timer-separator">:</div>
                <div class="timer-segment">
                    <span id="seconds" class="timer-number">00</span>
                    <span class="timer-label">Seconds</span>
                </div>
            </div>
            <!-- === END: IMPROVED TIMER UI === -->

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
                const timerContainer = document.getElementById("auctionTimerContainer");

                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = auctionEndTime - now;

                    // When the timer runs out, display "Auction Ended"
                    if (distance <= 0) {
                        if (timerContainer) {
                            timerContainer.innerHTML = `<div class="d-flex justify-content-center mb-3"><span class="badge-custom p-3 fw-bold">Auction Ended</span></div>`;
                        }
                        clearInterval(timerInterval);
                        return;
                    }

                    // Improved time calculations to show total hours
                    const hours = String(Math.floor(distance / (1000 * 60 * 60))).padStart(2, '0');
                    const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

                    // Display the remaining time
                    document.getElementById("hours").textContent = hours;
                    document.getElementById("minutes").textContent = minutes;
                    document.getElementById("seconds").textContent = seconds;
                }

                const timerInterval = setInterval(updateTimer, 1000);
                updateTimer(); // Call it once immediately so the timer doesn't start at 00:00:00 for a second
            });
        </script>


    </div>