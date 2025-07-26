@extends('layouts.guest')
@section('title')
    Home - GoldenX
@endsection
@section('content')
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center justify-content-center">
        <div class="hero-bg"></div>
        <div class="container hero-content">
            <h1 class="hero-title">Discover Exceptional Automobiles</h1>
            <p class="hero-subtitle">Explore our curated collection of premium vehicles and place your bid on automotive
                excellence.</p>
            <div class="filter-bar mt-4">
                <!-- Filter Tabs -->
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
                <!-- Filter Form -->
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
                    {{-- <div class="col-12 filter-actions">
                        <a href="#" class="filter-reset d-flex align-items-center">
                            <i class="fas fa-undo me-2"></i> Reset Filters
                        </a>
                        <button type="submit" class="btn btn-warning px-4">Search Auctions</button>
                    </div> --}}
                </form>
                <!-- Advanced Filters Toggle -->
                {{-- <div class="advanced-filters-toggle d-flex align-items-center mt-3" data-bs-toggle="collapse"
                    data-bs-target="#advancedFilters" aria-expanded="false" aria-controls="advancedFilters">
                    <span>Advanced Filters</span>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div> --}}
                <!-- Advanced Filters -->
                {{-- <div class="collapse advanced-filters mt-3" id="advancedFilters">
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
                </div> --}}
            </div>
        </div>
    </section>
    <!-- Featured Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: #0f172a;">Featured Auctions</h2>
                <p class="text-secondary mb-0">Discover our handpicked selection of exceptional vehicles currently
                    available for bidding.</p>
            </div>
            <div class="row g-4">
                @include('components.guest.listing-card')
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: #0f172a;">Featured Cars for Sale</h2>
                <p class="text-secondary mb-0">Looking for your next ride? Check out our featured cars—great deals on the
                    most popular models, all in one place..</p>
            </div>
            <div class="row g-4">
                @include('components.guest.listing-card')
            </div>
        </div>
    </section>
    <!-- CTA 2 -->
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="h-35 fw-600">Search for your favorite car or sell your car on AutoDecar</h2>
                </div>
            </div>
            <div class="row align-items-center g-4">
                <div class="col-lg-4">
                    <div class="card-box">
                        <img src="{{asset('images/icons/search-car.svg')}}" alt="Search Icon" class="icon">
                        <h5>Are you looking for a car?</h5>
                        <p>Save time and effort as you no longer need to visit multiple stores to find the right car.</p>
                        <a href="" class="btn-main">
                            Find cars
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                                viewBox="0 0 14 14">
                                <path
                                    d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="{{asset('images/Untitled design (27).png')}}" alt="Car" class="car-image">
                </div>
                <div class="col-lg-4">
                    <div class="card-box">
                        <img src="{{asset('images/icons/sell-car.svg')}}" alt="Sell Icon" class="icon">
                        <h5>Do you want to sell a car?</h5>
                        <p>Find your perfect car match and sell your car quickly with our user-friendly online service.</p>
                        <a href="" class="btn-main">
                            Sell a car
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                                viewBox="0 0 14 14">
                                <path
                                    d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SERVICES -->
    <section class="our-services">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">
                    <h3 class="sec-h-top">Our Services</h3>
                    <h2 class="h-35 fw-600">Explore our wide range of cars services</h2>
                </div>
            </div>
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-3">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s1.svg') }}" alt="Car with Driver" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Car Rental With Driver</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s2.svg') }}" alt="Business Car" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Business Car Rental</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s3.svg') }}" alt="Airport Transfer" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Airport Transfer</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                                    viewBox="0 0 14 14">
                                    <path
                                        d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="service-card h-100">
                        <div class="service-card-inner">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/icons/s4.svg') }}" alt="Chauffeur" width="24">
                            </div>
                            <h5 class="p-20 fw-600">Chauffeur Services</h5>
                            <p class="text-muted mb-4">Enhance your rental experience with additional options.</p>
                            <a href="" class="arrow-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                        viewBox="0 0 14 14">
                        <path
                            d="M11.6654 3.97592L1.64141 13.9999L-0.00537109 12.3531L10.0174 2.32914H1.18372V-0.00012207H13.9946V12.8108H11.6654V3.97592Z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section class="cta-section mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <h2 class="h-35 fw-700">Ready to get your car inspected?<br />Schedule your inspection today!</h2>
                    <p class="cta-text p-20">
                        Our friendly customer service team is here to help. Contact us anytime for support and inquiries.
                    </p>
                    <a href="" class="btn-main">
                        Contact Us
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 14 14">
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
    <section class="section-testimonail">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">
                    <h3 class="sec-h-top">Testimonials</h3>
                    <h2 class="h-35 fw-600">What our customers are saying about us</h2>
                </div>
            </div>
        </div>
        <div class="testimonail_slider slider-testimonal owl-carousel owl-theme">
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="item">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>
    <!-- Blogs -->
    <section class="section-blog">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <h3 class="sec-h-top">Latest Blog</h3>
                    <h2 class="h-35 fw-600">Insights That Fuel Every Car Deal</h2>
                </div>
            </div>
            <div class="row g-4 align-items-stretch">
                <!-- Featured Post -->
                <div class="col-lg-6">
                    <div class="featured-post position-relative">
                        <div class="feature-post-img">
                            <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-1.jpg"
                                class="img-fluid w-100 h-100 object-fit-cover rounded-4" alt="Featured Post">
                        </div>
                        <div class="featured-content text-white">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h4 class="p-22 fw-600 my-3">Top Tips For Booking Your Car Rental: What You Need To Know</h4>
                            <a href="#" class="read-more-icon d-inline-block">
                                <span class="icon-circle"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Side Posts -->
                <div class="col-lg-6 d-flex flex-column gap-4">
                    <!-- Single Side Post -->
                    <div class="side-post row align-items-center">
                        <div class="col-lg-4">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="side-post row align-items-center">
                        <div class="col-lg-4">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="side-post row align-items-center">
                        <div class="col-lg-4">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
