@extends('layouts.guest')
@section('title')
    Home - GoldenX
@endsection
@section('content')
    <!-- Hero Section -->
    {{-- <section class="hero-section d-flex align-items-center justify-content-center">
        <div class="hero-bg"></div>
        <div class="container hero-content">
            <h1 class="hero-title">Discover Exceptional Automobiles</h1>
            <p class="hero-subtitle">Explore our curated collection of premium vehicles and place your bid on automotive
                excellence.</p>
            <div class="filter-bar mt-4">
                <ul class="nav filter-tabs mb-4" id="auctionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                            type="button" role="tab">All Auctions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ending-tab" data-bs-toggle="tab" data-bs-target="#ending"
                            type="button" role="tab">Ending Soon</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="noreserve-tab" data-bs-toggle="tab" data-bs-target="#noreserve"
                            type="button" role="tab">No Reserve</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent"
                            type="button" role="tab">Recently Added</button>
                    </li>
                </ul>
                <form class="row g-3">
                    <div class="col-md-3">
                        <label for="make" class="form-label">Make</label>
                        <select id="make" class="form-select">
                            <option value="">All Makes</option>
                            <option>Porsche</option>
                            <option>Ferrari</option>
                            <option>Lamborghini</option>
                            <option>Aston Martin</option>
                            <option>Bentley</option>
                            <option>McLaren</option>
                            <option>Mercedes-Benz</option>
                            <option>BMW</option>
                            <option>Audi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="model" class="form-label">Model</label>
                        <select id="model" class="form-select">
                            <option value="">All Models</option>
                            <option>911</option>
                            <option>Cayman</option>
                            <option>Boxster</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <div class="input-group">
                            <select class="form-select" id="year-min">
                                <option value="">From</option>
                                <option>2023</option>
                                <option>2020</option>
                                <option>2015</option>
                                <option>2010</option>
                                <option>2000</option>
                                <option>1990</option>
                                <option>1980</option>
                                <option>1970</option>
                                <option>1960</option>
                            </select>
                            <select class="form-select" id="year-max">
                                <option value="">To</option>
                                <option>2025</option>
                                <option>2023</option>
                                <option>2020</option>
                                <option>2015</option>
                                <option>2010</option>
                                <option>2000</option>
                                <option>1990</option>
                                <option>1980</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Price Range</label>
                        <div class="input-group">
                            <select class="form-select" id="price-min">
                                <option value="">Min</option>
                                <option>$10,000</option>
                                <option>$25,000</option>
                                <option>$50,000</option>
                                <option>$100,000</option>
                                <option>$250,000</option>
                            </select>
                            <select class="form-select" id="price-max">
                                <option value="">Max</option>
                                <option>$50,000</option>
                                <option>$100,000</option>
                                <option>$250,000</option>
                                <option>$500,000</option>
                                <option>$1,000,000+</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 filter-actions">
                        <a href="#" class="filter-reset d-flex align-items-center">
                            <i class="fas fa-undo me-2"></i> Reset Filters
                        </a>
                        <button type="submit" class="btn btn-warning px-4">Search Auctions</button>
                    </div>
                </form>
                <div class="advanced-filters-toggle d-flex align-items-center mt-3" data-bs-toggle="collapse"
                    data-bs-target="#advancedFilters" aria-expanded="false" aria-controls="advancedFilters">
                    <span>Advanced Filters</span>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div>
                <div class="collapse advanced-filters mt-3" id="advancedFilters">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Body Style</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="coupe">
                                <label class="form-check-label" for="coupe">Coupe</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="convertible">
                                <label class="form-check-label" for="convertible">Convertible</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sedan">
                                <label class="form-check-label" for="sedan">Sedan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="suv">
                                <label class="form-check-label" for="suv">SUV</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Transmission</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="automatic">
                                <label class="form-check-label" for="automatic">Automatic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manual">
                                <label class="form-check-label" for="manual">Manual</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="semiauto">
                                <label class="form-check-label" for="semiauto">Semi-Auto</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Drivetrain</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rwd">
                                <label class="form-check-label" for="rwd">RWD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="awd">
                                <label class="form-check-label" for="awd">AWD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="fwd">
                                <label class="form-check-label" for="fwd">FWD</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="mileage" class="form-label">Maximum Mileage</label>
                            <select id="mileage" class="form-select">
                                <option value="">Any Mileage</option>
                                <option>Under 5,000 miles</option>
                                <option>Under 10,000 miles</option>
                                <option>Under 25,000 miles</option>
                                <option>Under 50,000 miles</option>
                                <option>Under 100,000 miles</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="color" class="form-label">Exterior Color</label>
                            <select id="color" class="form-select">
                                <option value="">Any Color</option>
                                <option>Black</option>
                                <option>White</option>
                                <option>Silver</option>
                                <option>Gray</option>
                                <option>Red</option>
                                <option>Blue</option>
                                <option>Green</option>
                                <option>Yellow</option>
                                <option>Orange</option>
                                <option>Brown</option>
                                <option>Purple</option>
                                <option>Gold</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Features</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="oneowner">
                                <label class="form-check-label" for="oneowner">One Owner</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="noaccidents">
                                <label class="form-check-label" for="noaccidents">No Accidents</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="servicehistory">
                                <label class="form-check-label" for="servicehistory">Service History</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="home-banner">
        <video class="bg-video" autoplay muted loop playsinline>
            <source src="https://demo.awaikenthemes.com/assets/videos/novaride-video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="banner-content" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                        <h5 class="banner-text-sm">Buy. Sell. Auction</h5>
                        <h1 class="banner-heading mt-4 mb-3">Your Trusted Destination to Buy, Sell & Auction Cars</h1>
                        <p class="p-text">From finding your dream ride to getting the best deal for your car,<br> we're here to make it easy and hassle-free.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-bar mt-4">
                        <form class="row align-items-end g-2">
                            <div class="col-xl-4 col-lg-6">
                                <label for="make" class="form-label">Make</label>
                                <select id="make" class="form-select">
                                    <option value="">All Makes</option>
                                    <option>Porsche</option>
                                    <option>Ferrari</option>
                                    <option>Lamborghini</option>
                                    <option>Aston Martin</option>
                                    <option>Bentley</option>
                                    <option>McLaren</option>
                                    <option>Mercedes-Benz</option>
                                    <option>BMW</option>
                                    <option>Audi</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <label for="model" class="form-label">Model</label>
                                <select id="model" class="form-select">
                                    <option value="">All Models</option>
                                    <option>911</option>
                                    <option>Cayman</option>
                                    <option>Boxster</option>
                                </select>
                            </div>
                            <div class="col-xl-2 col-lg-6">
                                <label class="form-label">Year</label>
                                <div class="input-group">
                                    <select class="form-select" id="year-min">
                                        <option value="">From</option>
                                        <option>2023</option>
                                        <option>2020</option>
                                        <option>2015</option>
                                        <option>2010</option>
                                        <option>2000</option>
                                        <option>1990</option>
                                        <option>1980</option>
                                        <option>1970</option>
                                        <option>1960</option>
                                    </select>
                                    <select class="form-select" id="year-max">
                                        <option value="">To</option>
                                        <option>2025</option>
                                        <option>2023</option>
                                        <option>2020</option>
                                        <option>2015</option>
                                        <option>2010</option>
                                        <option>2000</option>
                                        <option>1990</option>
                                        <option>1980</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-6">
                                <label class="form-label">Price Range</label>
                                <div class="input-group">
                                    <select class="form-select" id="price-min">
                                        <option value="">Min</option>
                                        <option>$10,000</option>
                                        <option>$25,000</option>
                                        <option>$50,000</option>
                                        <option>$100,000</option>
                                        <option>$250,000</option>
                                    </select>
                                    <select class="form-select" id="price-max">
                                        <option value="">Max</option>
                                        <option>$50,000</option>
                                        <option>$100,000</option>
                                        <option>$250,000</option>
                                        <option>$500,000</option>
                                        <option>$1,000,000+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-12 filter-actions">
                                {{-- <a href="#" class="filter-reset d-flex align-items-center">
                                    <i class="fas fa-undo me-2"></i>
                                </a> --}}
                                <button type="submit" class="btn-main ms-auto p-0">
                                    <i class="fa-solid fa-magnifying-glass mx-auto"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Section -->
    <section class="ox-hidden">
        <div class="card-slider-wrap">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8">
                    <h2 class="h-35 fw-700">Featured Auctions</h2>
                    <p class="text-secondary mb-0">Discover our handpicked selection of exceptional vehicles currently available for bidding.</p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="" class="btn-main">View All</a>
                </div>
            </div>
            <div class="cars-card-slider owl-carousel owl-theme">
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ox-hidden section-auction">
        <div class="card-slider-wrap">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8">
                    <h2 class="h-35 fw-700">Featured Auctions</h2>
                    <p class="text-secondary mb-0">Looking for your next ride? Check out our featured cars—great deals on the most popular models, all in one place..</p>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="" class="btn-main">View All</a>
                </div>
            </div>
            <div class="cars-card-slider owl-carousel owl-theme">
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="car-box-card" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="car-box-card-images">
                        <div class="car-box-card-images-inner">
                            <a href="{{ route('car-detail-page') }}" class="car-box-card-imag-item">
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
                        <div class="mt-3">
                            <a href="" class="view-detail-btn">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA 2 -->
    <section class="main-section ox-hidden">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="h-35 fw-700">Search for your favorite car or sell your car on AutoDecar</h2>
                </div>
            </div>
            <div class="row align-items-center g-4">
                <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="card-box">
                        <img src="{{asset('images/icons/search-car.svg')}}" alt="Search Icon" class="icon">
                        <h5>Are you looking for a car?</h5>
                        <p>Save time and effort as you no longer need to visit multiple stores to find the right car.</p>
                        <a href="" class="btn-main">
                            Find cars
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="{{asset('images/Untitled design (27).png')}}" alt="Car" class="car-image">
                </div>
                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="card-box">
                        <img src="{{asset('images/icons/sell-car.svg')}}" alt="Sell Icon" class="icon">
                        <h5>Do you want to sell a car?</h5>
                        <p>Find your perfect car match and sell your car quickly with our user-friendly online service.</p>
                        <a href="{{route('sell-car')}}" class="btn-main">
                            Sell a car
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SERVICES -->
    <section class="our-services ox-hidden">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">
                    <h3 class="sec-h-top">Our Services</h3>
                    <h2 class="h-35 fw-700">Explore our wide range of cars services</h2>
                </div>
            </div>
            <div class="row g-4 text-start">
                <div class="col-lg-3 col-md-6" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s1.svg') }}" alt="Car with Driver" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Car Rental With Driver</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s2.svg') }}" alt="Business Car" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Business Car Rental</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s3.svg') }}" alt="Airport Transfer" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Airport Transfer</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s4.svg') }}" alt="Chauffeur" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Chauffeur Services</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-text mt-5">
                <p>Discover our range of car rental services designed to meet all your travel needs.<br>From a diverse fleet
                    of vehicles to flexible rental plans.</p>
                <a href="" class="btn-main">
                    View All Service
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b"
                        viewBox="0 0 14 14">
                        <path
                            d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section class="cta-section mt-5 ox-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start" data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <h2 class="h-35 fw-700">Ready to get your car inspected?<br />Schedule your inspection today!</h2>
                    <p class="cta-text p-20">
                        Our friendly customer service team is here to help. Contact us anytime for support and inquiries.
                    </p>
                    <a href="" class="btn-main white">
                        Contact Us
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 14 14">
                            <path d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                        </svg>
                    </a>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('images/cars-inspection.png') }}" alt="Car Image" class="cta-img" />
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonail -->
    @livewire('testimonial-listing-component')
    <!-- FAQ -->
    <section class="section-faq ox-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="faq-img">
                        <img src="{{asset('images/faq.webp')}}" class="img-fluid rounded-4" alt="">
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <h3 class="sec-h-top mx-0 mb-3">Frequently Asked Questions</h3>
                    <h2 class="h-35 fw-700 mb-4">Everything you need to know about ourservices</h2>
                    <div class="custom-accordion">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    What Do I Need To Rent A Car?
                                </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Explore our diverse selection of high-end vehicles, choose your preferred pickup and return dates, and select a location that best fits your needs
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        How Old Do I Need To Be To Rent A Car
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Explore our diverse selection of high-end vehicles, choose your preferred pickup and return dates, and select a location that best fits your needs
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                        Can I Rent A Car With A Debit Card?
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Explore our diverse selection of high-end vehicles, choose your preferred pickup and return dates, and select a location that best fits your needs
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blogs -->
    @livewire('blog-listing-component')
    <!-- CTA 3 -->
    <section class="ft-cta py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                <h2 class="h-40 fw-600">Ready to Sell Your Car?</h2>
                <p class="mb-4">Get the best value fast — simple, secure, and hassle-free.</p>
                </div>
                <div class="col-lg-3">
                <a href="{{route('sell-car')}}" class="btn-main">
                    Sell Your Car Now
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 14 14">
                        <path d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z"></path>
                    </svg>
                </a>
                </div>
            </div>
        </div>
    </section>
@endsection
