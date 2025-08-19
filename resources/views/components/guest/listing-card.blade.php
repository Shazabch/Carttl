<!-- Car Card 3 -->
{{-- <div class="col-md-6 col-lg-4">
    <div class="card car-card position-relative h-100">
        <img src="https://placehold.co/600x400/1e293b/f8fafc?text=BMW+M4" class="card-img-top" alt="BMW M4">
        <div class="car-badge hot">Hot Bid</div>
        <div class="wishlist-btn">
            <i class="far fa-heart"></i>
        </div>
        <div class="card-body">
            <h5 class="card-title">2022 BMW M4 Competition</h5>
            <div class="fw-bold mb-2 current-bid">Current Bid: AED 78,000.00</div>
            <div class="d-flex justify-content-between text-secondary small mb-3">
                <span><i class="fas fa-tachometer-alt me-1"></i>12,300 miles</span>
                <span><i class="fas fa-clock me-1"></i>Ends in 1d</span>
                <span><i class="fas fa-user me-1"></i>9 bids</span>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('car-detail-page',1) }}" class="btn btn-warning btn-sm">View Details</a>
                <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-lg-4">
    <div class="car-box-card">
        <div class="car-box-card-images">
            <div class="car-box-card-images-inner">
                <a href="{{ route('car-detail-page',1) }}" class="car-box-card-imag-item">
                    <img src="{{asset('images/default-car.webp')}}" class="obj_fit" alt="Rent Property Listing">
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
        <div class="car-box-card-content pt-3">
            <div class="car-box-other-detail">
                <h3>Jeep Wrangler Rubicon</h3>
                <div class="car-box-specs">
                    <div class="spec_item">
                        <img src="{{asset('images/icons/meter.svg')}}" alt="">
                        <span>290 m</span>
                    </div>
                    <div class="spec_item">
                        <img src="{{asset('images/icons/time.svg')}}" alt="">
                        <span>Ends in 1d</span>
                    </div>
                    <div class="spec_item">
                        <img src="{{asset('images/icons/user-check.svg')}}" alt="">
                        <span>9 bids</span>
                    </div>
                </div>
            </div>
            <div class="car-box-price-and-specs">
                <div class="car-box-price">
                    <h4 class="mb-0">Current Bid:</h4>
                    <h4 class="mb-0 car-box-price-text">AED 78,000.00</h4>
                </div>
            </div>
        </div>
    </div>
</div>


