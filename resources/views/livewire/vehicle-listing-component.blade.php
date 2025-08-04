<div>
<section class="ox-hidden section-auction">
        <div class="card-slider-wrap">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="h-35 fw-700">Featured {{$section}}</h2>
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
                                    <img src="{{asset('images/icons/eng.png')}}" alt="">
                                    <span>{{$item->engine_type}}</span>
                                </div>
                                <div class="spec_item">
                                    <img src="{{asset('images/icons/clr.png')}}" alt="">
                                    <span>{{$item->color}}</span>
                                </div>
                                <div class="spec_item">
                                    <img src="{{asset('images/icons/dtype.png')}}" alt="">
                                    <span>{{$item->drive_type}}</span>
                                </div>
                            </div>
                        </div>
                        
                        
                           <div class="car-box-price-and-specs">
                            <div class="car-box-price">
                                <h4 class="mb-0">Price</h4>
                                <h4 class="mb-0 car-box-price-text">{{$item->price}}</h4>
                            </div>
                        </div>
                         
                        
                        <div class="mt-3">
                            <a href="#" class="view-detail-btn">Buy Now</a>
                        </div>
                         <div class="mt-1">
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
                                    <span>End In 1d</span>
                                </div>
                                <div class="spec_item">
                                    <img src="{{asset('images/icons/user-check.svg')}}" alt="">
                                    <span>8 Bids</span>
                                </div>
                            </div>
                        </div>
                        
                         
                           <div class="car-box-price-and-specs">
                            <div class="car-box-price">
                                <h4 class="mb-0">Current Bid:</h4>
                                <h4 class="mb-0 car-box-price-text">AED 78,000.00</h4>
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