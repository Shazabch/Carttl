<!-- Car Card 3 -->

<!--<div class="col-lg-4">
    <div class="car-box-card">
        <div class="car-box-card-images">
            <div class="car-box-card-images-inner">
                <a href="{{ route('car-detail-page',$item->id) }}" class="car-box-card-imag-item">
                    <img src="{{asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp')}}" class="obj_fit" alt="Rent Property Listing">
                </a>
            </div>
            <div class="overlap-car-box-card">
                <div class="car-box-type p-left">
                    <span class="car-box-badge">
                        <img src="{{asset('images/icons/fire.svg')}}" alt="">
                        Hot Bid
                    </span>
                </div>
                <div class="wishlist-btn">
                    <i class="far fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="car-box-card-content">
            <div class="car-box-other-detail">
                <h3>{{$item->title}}</h3>
                <div class="car-box-specs">
                    <div class="spec_item">
                        <img src="{{asset('images/icons/meter.svg')}}" alt="">
                        <span>{{$item->mileage}} m</span>
                    </div>
                    <div class="spec_item">
                        <img src="{{asset('images/icons/time.svg')}}" alt="">
                        <span>End In {{ \Carbon\Carbon::parse($item->auction_end_date)->shortAbsoluteDiffForHumans() }}</span>
                    </div>
                    <div class="spec_item">
                        <img src="{{asset('images/icons/user-check.svg')}}" alt="">
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
    </div>-->
<div class="car-list-item">
    <div class="row align-items-center">
        <div class="col-md-3">
            <img src="{{asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp')}}"
                class="img-fluid rounded" alt="Porsche 911">
        </div>
        <div class="col-md-6">
            <h5 class="mb-2">{{$item->title}}</h5>
            <div class="fw-bold mb-2 current-bid">Current Bid: {{ $item->latestBid ? format_currency($item->latestBid->bid_amount) : 'No bids yet' }}</div>
            <div class="d-flex gap-3 text-secondary small">
                <span><i class="fas fa-tachometer-alt me-1"></i>{{$item->mileage}} miles</span>
                <span><i class="fas fa-clock me-1"></i>Ends In {{ \Carbon\Carbon::parse($item->auction_end_date)->shortAbsoluteDiffForHumans() }}</span>
                <span><i class="fas fa-user me-1"></i>{{ $item->bids->count() ?? 0 }} Bids</span>
            </div>
        </div>
        <div class="col-md-3 text-end">
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('car-detail-page',$item->id) }}" class="btn btn-warning btn-sm">View Details</a>
                <a href="{{ route('car-detail-page',$item->id) }}" class="btn btn-outline-warning btn-sm">Watch</a>
            </div>
        </div>
    </div>
</div>