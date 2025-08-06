<div>
    <div class="auction-card">
        <div class="auction-header">
            <p class="auction-id mb-1">#AU-2024-0156</p>
            <h3>{{$selected_vehicle->title}}</h3>
        </div>
        <div class="car-subtitle">
            @foreach($tags as $feature)
            <span class="badge-custom">{{$feature->name}}</span>
            @endforeach
        </div>
        <div class="current-bid">
            <span class="bid-label mb-0">Current Bid</span>
            <span class="bid-amount">{{format_currency($highestBid)}}</span>
            <span class="bid-count">{{$totalBids}} bids</span>
        </div>
        <div class="action-buttons mb-2">
            <button class="btn-icon active" data-bs-toggle="tooltip" title="Add to Watchlist">
                <i class="far fa-heart"></i>
            </button>
            <button class="btn-icon" data-bs-toggle="tooltip" title="Share">
                <i class="fas fa-share-alt"></i>
            </button>
            <button class="btn-icon" data-bs-toggle="tooltip" title="Print">
                <i class="fas fa-print"></i>
            </button>
        </div>
        <div class="bid-history">
            @foreach($bids as $bid)
            <div class="bid-item">
                <span class="bidder">{{$bid->user->name}}</span>
                <span class="bid-amount">${{$bid->bid_amount}}</span>
                <span class="bid-time">{{ \Carbon\Carbon::parse($bid->created_at)->diffForHumans() }}</span>
            </div>
            @endforeach

        </div>
        <div class="bid-actions">
            <div class="bid-input-group">
                <input type="number" wire:model="current_bid" class="form-control bid-input"
                    placeholder="Enter bid ">
                @error('current_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <span class="input-addon">USD</span>
            </div>
            <div class="bid-input-group">
                <input type="number" wire:model="max_bid" class="form-control bid-input"
                    placeholder="Enter Max Bid">
                @error('max_bid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <span class="input-addon">USD</span>
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
                <span>Dec 28, 2024 at 3:00 PM PST</span>
            </div>
            <div class="detail-row">
                <span>Location:</span>
                <span>Beverly Hills, CA</span>
            </div>
            <div class="detail-row">
                <span>Shipping:</span>
                <span>Buyer Arranges</span>
            </div>
        </div>
    </div>
</div>