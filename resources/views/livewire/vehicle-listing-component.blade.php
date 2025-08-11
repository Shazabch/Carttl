<div>

    <section class="ox-hidden section-auction">
        <div class="card-slider-wrap">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8 mb-4 mb-lg-0">

                    <h2 class="h-35 fw-700">{{$title}}</h2>
                    <p class="text-secondary mb-0">Looking for your next ride? Check out our featured cars—great deals on the most popular models, all in one place..</p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="" class="btn-main">View All</a>
                </div>
            </div>
            <div class="cars-card-slider owl-carousel owl-theme">
                @foreach($vehicles as $item)
                @if($section=='Vehicles')
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page',$item->id) }}" class="car-box-card-imag-item">
                                <img src="{{ $item->coverImage ?  asset('storage/' . $item->coverImage?->path) : asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp') }}" class="obj_fit" alt="Rent Property Listing">
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
                                    <span>{{$item->engine_type}}</span>
                                </div>
                                <div class="spec_item">
                                    <i class="fas fa-palette"></i>
                                    <span>{{$item->color}}</span>
                                </div>
                                <div class="spec_item">
                                    <i class="fas fa-user"></i>
                                    <span>{{$item->seats}}</span>
                                </div>
                            </div>
                        </div>


                        <div class="car-box-price-and-specs">
                            <div class="car-box-price">
                                <h4 class="mb-0">Price</h4>
                                <h4 class="mb-0 car-box-price-text"> {{format_currency($item->price)}}</h4>
                            </div>
                        </div>


                        <!-- <div class="mt-3">
                            <a href="{{ route('car-detail-page',$item->id) }}" class="view-detail-btn">Buy Now</a>
                        </div> -->
                        <div class="mt-3">
                            <a href="{{ route('car-detail-page',$item->id) }}" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                @else
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
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
                                    <span>Ends In {{ \Carbon\Carbon::parse($item->auction_end_date)->shortAbsoluteDiffForHumans() }}</span>
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
                @endif
                @endforeach
            </div>
        </div>
    </section>
</div>