@extends('layouts.guest')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center justify-content-center">
        <div class="hero-bg"></div>

        <div class="container hero-content">
            <h1 class="hero-title">Discover Exceptional Automobiles</h1>
            <p class="hero-subtitle">Explore our curated collection of premium vehicles and place your bid on automotive
                excellence.</p>
            <div class="filter-bar mx-auto mt-4" style="max-width: 1100px;">
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
                    <div class="col-12 filter-actions">
                        <a href="#" class="filter-reset d-flex align-items-center">
                            <i class="fas fa-undo me-2"></i> Reset Filters
                        </a>
                        <button type="submit" class="btn btn-warning px-4">Search Auctions</button>
                    </div>
                </form>
                <!-- Advanced Filters Toggle -->
                <div class="advanced-filters-toggle d-flex align-items-center mt-3" data-bs-toggle="collapse"
                    data-bs-target="#advancedFilters" aria-expanded="false" aria-controls="advancedFilters">
                    <span>Advanced Filters</span>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div>
                <!-- Advanced Filters -->
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
    </section>
    <!-- Featured Section -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: #0f172a;">Featured Auctions</h2>
                <p class="text-secondary mb-0">Discover our handpicked selection of exceptional vehicles currently
                    available for bidding.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card car-card position-relative h-100">
                        <img src="https://placehold.co/600x400/1e293b/f8fafc?text=Porsche+911" class="card-img-top"
                            alt="Porsche 911">
                        <div class="car-badge">Hot Bid</div>
                        <div class="card-body">
                            <h5 class="card-title">2021 Porsche 911 Turbo S</h5>
                            <div class="fw-bold mb-2" style="color: #f59e0b;">Current Bid: $185,000</div>
                            <div class="d-flex justify-content-between text-secondary small mb-3">
                                <span><i class="fas fa-tachometer-alt me-1"></i>3,200 miles</span>
                                <span><i class="fas fa-clock me-1"></i>Ends in 2d</span>
                                <span><i class="fas fa-user me-1"></i>18 bids</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card car-card position-relative h-100">
                        <img src="https://placehold.co/600x400/1e293b/f8fafc?text=Ferrari+F8" class="card-img-top"
                            alt="Ferrari F8">
                        <div class="car-badge">No Reserve</div>
                        <div class="card-body">
                            <h5 class="card-title">2020 Ferrari F8 Tributo</h5>
                            <div class="fw-bold mb-2" style="color: #f59e0b;">Current Bid: $275,000</div>
                            <div class="d-flex justify-content-between text-secondary small mb-3">
                                <span><i class="fas fa-tachometer-alt me-1"></i>1,800 miles</span>
                                <span><i class="fas fa-clock me-1"></i>Ends in 4d</span>
                                <span><i class="fas fa-user me-1"></i>24 bids</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card car-card position-relative h-100">
                        <img src="https://placehold.co/600x400/1e293b/f8fafc?text=Aston+Martin" class="card-img-top"
                            alt="Aston Martin">
                        <div class="card-body">
                            <h5 class="card-title">2019 Aston Martin DBS Superleggera</h5>
                            <div class="fw-bold mb-2" style="color: #f59e0b;">Current Bid: $198,000</div>
                            <div class="d-flex justify-content-between text-secondary small mb-3">
                                <span><i class="fas fa-tachometer-alt me-1"></i>5,400 miles</span>
                                <span><i class="fas fa-clock me-1"></i>Ends in 1d</span>
                                <span><i class="fas fa-user me-1"></i>15 bids</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card car-card position-relative h-100">
                        <img src="https://placehold.co/600x400/1e293b/f8fafc?text=McLaren" class="card-img-top"
                            alt="McLaren">
                        <div class="card-body">
                            <h5 class="card-title">2021 McLaren 720S Spider</h5>
                            <div class="fw-bold mb-2" style="color: #f59e0b;">Current Bid: $245,000</div>
                            <div class="d-flex justify-content-between text-secondary small mb-3">
                                <span><i class="fas fa-tachometer-alt me-1"></i>2,100 miles</span>
                                <span><i class="fas fa-clock me-1"></i>Ends in 3d</span>
                                <span><i class="fas fa-user me-1"></i>20 bids</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
@endsection
