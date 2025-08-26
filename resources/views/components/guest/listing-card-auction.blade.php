<!-- Car Card 3 -->

<div class="col-lg-4">
    <div class="car-box-card">
        <div class="car-box-card-images">
            <div class="car-box-card-images-inner">
                <a href="{{ route('car-detail-page',$item->id) }}" class="car-box-card-imag-item">
                    <img src="{{ $item->coverImage ?  asset('storage/' . $item->coverImage?->path) : asset('images/default-car.webp') }}" class="obj_fit" alt="Rent Property Listing">
                </a>
            </div>
            <div class="overlap-car-box-card">
                <div class="car-box-type p-left d-flex flex-wrap gap-2">
                    @if($item->is_hot)
                    <span class="car-box-badge hot">
                        Hot Bid
                    </span>
                    @endif

                    @if($item->inspected_by)
                    <span class="car-box-badge inspected">
                        Inspected
                    </span>
                    @endif

                    @if(!$item->is_auction && $item->status == 'sold')
                    <span class="car-box-badge sold">
                        Sold
                    </span>
                    @endif

                    @if($item->condition)
                    <span class="car-box-badge condition">
                        {{ucfirst($item->condition)}}
                    </span>
                    @endif
                </div>
                <livewire:favorite-button-component :vehicleId="$item->id" />
            </div>
        </div>
        <div class="car-box-card-content">
            <div class="car-box-other-detail">
                <h3 class="title-line-clamp-2">{{$item->title}}</h3>
                <div class="car-box-specs">
                    <div class="spec_item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{$item->mileage}} m</span>
                    </div>
                    <div class="spec_item">
                        <i class="fas fa-calendar-alt"></i>
                        @php
                        $start = \Carbon\Carbon::parse($item->auction_start_date);
                        $end = \Carbon\Carbon::parse($item->auction_end_date);
                        $now = now();
                        @endphp

                        @if($now->lt($start))
                        <span>Starts In {{ $start->shortAbsoluteDiffForHumans() }}</span>
                        @elseif($now->between($start, $end))
                        <span>Ends In {{ $end->shortAbsoluteDiffForHumans() }}</span>
                        @else
                        <span>Auction Ended</span>
                        @endif
                    </div>

                    <div class="spec_item">
                        <i class="fas fa-gavel"></i>
                        <span>{{ $item->bids->count() ?? 0 }} Bids</span>
                    </div>
                </div>
            </div>


            <div class="car-box-price-and-specs">
                <div class="car-box-price">
                    <h4 class="mb-0">Current Bid:</h4>
                    <h4 class="mb-0 car-box-price-text">{{ $item->latestBid ? format_currency($item->latestBid->bid_amount) : 'No bids yet' }}</h4>
                </div>
            </div>


            <div class="mt-3">
                <a href="{{ route('car-detail-page',$item->id) }}" class="view-detail-btn">View Detail</a>
            </div>
        </div>
    </div>
</div>