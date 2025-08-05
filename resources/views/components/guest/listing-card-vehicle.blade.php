<!-- Car Card 3 -->

<div class="col-lg-4">
    <div class="car-box-card" >
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
                                <h4 class="mb-0 car-box-price-text">${{$item->price}}</h4>
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
</div>


