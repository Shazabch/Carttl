<!-- Car Card 3 -->
<div class="car-list-item">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="listing-product-img">
                <img src="{{ $item->coverImage ? asset('storage/' . $item->coverImage?->path) : asset('images/default-car.webp') }}"
                    class="img-fluid rounded" alt="{{ $item->title }}">
                <div class="overlap-car-box-card">
                    <div class="car-box-type p-left d-flex flex-wrap gap-2">
                        @if ($item->is_hot)
                        <span class="car-box-badge hot">
                            Hot Bid
                        </span>
                        @endif

                        @if ($item->inspected_by)
                        <span class="car-box-badge inspected">
                            Inspected
                        </span>
                        @endif

                        @if (!$item->is_auction && $item->status == 'sold')
                        <span class="car-box-badge sold">
                            Sold
                        </span>
                        @endif

                        @if ($item->condition)
                        <span class="car-box-badge condition">
                            {{ ucfirst($item->condition) }}
                        </span>
                        @endif
                    </div>
                    <livewire:favorite-button-component :vehicleId="$item->id" />
                </div>
            </div>
        </div>
        <div class="col-md-6 pt-md-0 pt-4">
            <h5 class="list-car-title">{{ $item->title }}</h5>
            <div class="car-box-price mb-4">
                <h4 class="mb-0">Current Bid:</h4>
                <h4 class="mb-0 car-box-price-text">
                    {{ $item->latestBid ? format_currency($item->latestBid->bid_amount) : 'No bids yet' }}
                </h4>
            </div>
            <div class="car-box-specs">
                <div class="spec_item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ $item->mileage }} m</span>
                </div>
                <div class="spec_item">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="auctionStatuslist{{ $item->id }}">Loading...</span>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const startDate = new Date("{{ \Carbon\Carbon::parse($item->auction_start_date)->format('Y-m-d H:i:s') }}").getTime();
                        const endDate = new Date("{{ \Carbon\Carbon::parse($item->auction_end_date)->format('Y-m-d H:i:s') }}").getTime();
                        const nowDate = new Date("{{ now()->format('Y-m-d H:i:s') }}").getTime();

                        const statusEl = document.getElementById("auctionStatuslist{{ $item->id }}");

                        function updateStatus() {
                            const now = new Date().getTime(); // client time tick

                            if (now < startDate) {
                                statusEl.textContent = "Starts In " + timeDiff(startDate - now);
                            } else if (now >= startDate && now <= endDate) {
                                statusEl.textContent = "Ends In " + timeDiff(endDate - now);
                            } else {
                                statusEl.textContent = "Auction Ended";
                                clearInterval(timerInterval);
                            }
                        }

                        function timeDiff(ms) {
                            const totalMinutes = Math.floor(ms / (1000 * 60));
                            const totalHours = Math.floor(totalMinutes / 60);
                            const totalDays = Math.floor(totalHours / 24);

                            if (totalDays >= 1) {
                                return totalDays + " " + (totalDays === 1 ? "day" : "days");
                            } else if (totalHours >= 1) {
                                return totalHours + " " + (totalHours === 1 ? "hour" : "hours");
                            } else if (totalMinutes > 0) {
                                return totalMinutes + " " + (totalMinutes === 1 ? "min" : "min");
                            } else {
                                return "Few Sec";
                            }
                        }

                        updateStatus();
                        const timerInterval = setInterval(updateStatus, 60000); // update every minute
                    });
                </script>
                <div class="spec_item">
                    <i class="fas fa-gavel"></i>
                    <span>{{ $item->bids->count() ?? 0 }} Bids</span>
                </div>
            </div>
            <a href="{{ route('car-detail-page', $item->id) }}" class="view-detail-btn mt-3">View Details</a>
        </div>
    </div>
</div>