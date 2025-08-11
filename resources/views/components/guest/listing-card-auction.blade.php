<!-- Car Card 3 -->

<div class="col-lg-4">
    <div class="car-box-card">
        <div class="car-box-card-images">
            <div class="car-box-card-images-inner">
                <a href="{{ route('car-detail-page',$item->id) }}" class="car-box-card-imag-item">
                    <img src="{{asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp')}}" class="obj_fit" alt="Rent Property Listing">
                </a>
            </div>
            <div class="overlap-car-box-card">
                <div class="car-box-type p-left d-flex align-items-center gap-2">
                    @if($item->is_hot)
                    <span class="car-box-badge">
                        <img src="{{asset('images/icons/fire.svg')}}" alt="">
                        Hot Bid
                    </span>
                    @endif
                    @if($item->inspected_by)
                    <span class="car-box-badge bg-primary text-light">
                        <img src="{{asset('images/icons/star.svg')}}" alt="">
                        Inspected
                    </span>
                    @endif
                    @if(!$item->is_auction && $item->status == 'sold')
                    <span class="car-box-badge bg-custom-primary text-light" style="background-color: #d7b236;">
                        <i class="fas fa-check mx-2"></i>
                        <span>Sold</span>
                    </span>
                    @endif
                    @if($item->condition)
                    <span class="car-box-badge bg-secondary text-light">
                        <i class="fas fa-car mx-2"></i>
                        <span>{{ucfirst($item->condition)}}</span>
                    </span>
                    @endif
                </div>
                 <livewire:favorite-button-component :vehicleId="$item->id" />
            </div>
        </div>
        <div class="car-box-card-content">
            <div class="car-box-other-detail">
                <h3>{{$item->title}}</h3>
                <div class="car-box-specs">
                    <div class="spec_item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{$item->mileage}} m</span>
                    </div>
                    <div class="spec_item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Ends In {{ \Carbon\Carbon::parse($item->auction_end_date)->shortAbsoluteDiffForHumans() }}</span>
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