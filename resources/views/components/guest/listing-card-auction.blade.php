<!-- Car Card 3 -->

<div class="col-lg-4">
    <div class="car-box-card">
        <div class="car-box-card-images">
            <div class="car-box-card-images-inner">
                <a href="{{ route('car-detail-page', $item->id) }}" class="car-box-card-imag-item">
                    <img src="{{ $item->coverImage ? asset('storage/' . $item->coverImage?->path) : asset('images/default-car.webp') }}"
                        class="obj_fit" alt="Rent Property Listing">
                </a>
            </div>
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
        <div class="car-box-card-content">
            <div class="car-box-other-detail">
                <h3 class="title-line-clamp-2">{{ $item->title }}</h3>
                <div class="car-box-specs">
                    <div class="spec_item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{ $item->mileage }} m</span>
                    </div>
                    <div class="spec_item">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="auctionStatus{{ $item->id }}">Loading...</span>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const startDate = new Date("{{ \Carbon\Carbon::parse($item->auction_start_date)->format('Y-m-d H:i:s') }}").getTime();
                            const endDate = new Date("{{ \Carbon\Carbon::parse($item->auction_end_date)->format('Y-m-d H:i:s') }}").getTime();
                            const nowDate = new Date("{{ now()->format('Y-m-d H:i:s') }}").getTime();

                            const statusEl = document.getElementById("auctionStatus{{ $item->id }}");

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
                                    return "less than a minute";
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
            </div>


            <div class="car-box-price-and-specs">
                <div class="car-box-price">
                    <h4 class="mb-0">Starting Bid:</h4>
                    <h4 class="mb-0 car-box-price-text">
                        {{ format_currency($item->starting_bid_amount) }}
                    </h4>
                </div>
            </div>


            <div class="mt-3">
                <a href="{{ route('car-detail-page', $item->id) }}" class="view-detail-btn">View Detail</a>
            </div>
        </div>
    </div>
</div>