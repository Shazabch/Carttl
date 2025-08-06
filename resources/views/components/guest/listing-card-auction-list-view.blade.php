<!-- Car Card 3 -->


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