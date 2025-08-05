<div>
    <div class="car-listing-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    {{-- <div class="filters-sidebar">
                        <div class="filters-header">
                            <h4 class="h-24">Filters</h4>
                            <button class="btn btn-link btn-sm text-warning p-0">Clear All</button>
                        </div>
                        <div class="filter-group">
                            <h6 class="filter-title">Price Range</h6>
                            <div class="price-inputs">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" placeholder="Min"
                                            value="50000">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" placeholder="Max"
                                            value="500000">
                                    </div>
                                </div>
                                <div class="price-range-slider mt-3">
                                    <input type="range" class="form-range" min="0" max="1000000" value="250000">
                                </div>
                            </div>
                        </div>

                        <!-- Make Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Make</h6>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="porsche" checked>
                                    <label class="form-check-label" for="porsche">Porsche <span
                                            class="count">(45)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ferrari">
                                    <label class="form-check-label" for="ferrari">Ferrari <span
                                            class="count">(32)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="lamborghini">
                                    <label class="form-check-label" for="lamborghini">Lamborghini <span
                                            class="count">(28)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="bmw">
                                    <label class="form-check-label" for="bmw">BMW <span
                                            class="count">(67)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="mercedes">
                                    <label class="form-check-label" for="mercedes">Mercedes-Benz <span
                                            class="count">(54)</span></label>
                                </div>
                                <button class="btn btn-link btn-sm p-0 text-warning mt-2">Show More</button>
                            </div>
                        </div>

                        <!-- Year Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Year</h6>
                           <select wire:model.live="year" class="form-select">
                            <option value="">Any Year</option>
                           <option value="2024">2024</option>
                            <option value="2023">2023</option>
                           <option value="2022">2022</option>
                          </select>

                        </div>

                        <!-- Mileage Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Mileage</h6>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mileage" id="under10k">
                                    <label class="form-check-label" for="under10k">Under 10,000 miles</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mileage" id="10k-25k">
                                    <label class="form-check-label" for="10k-25k">10,000 - 25,000 miles</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mileage" id="25k-50k">
                                    <label class="form-check-label" for="25k-50k">25,000 - 50,000 miles</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mileage" id="over50k">
                                    <label class="form-check-label" for="over50k">Over 50,000 miles</label>
                                </div>
                            </div>
                        </div>

                        <!-- Auction Status Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Auction Status</h6>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="live-auction" checked>
                                    <label class="form-check-label" for="live-auction">Live Auction</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ending-soon">
                                    <label class="form-check-label" for="ending-soon">Ending Soon</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="reserve-met">
                                    <label class="form-check-label" for="reserve-met">Reserve Met</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="buy-now">
                                    <label class="form-check-label" for="buy-now">Buy It Now</label>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="filter-box">
                        <div class="bx-white mb-4">
                            <div class="filter-header d-flex justify-content-between align-items-center mb-3">
                                <h5>Filters</h5>
                                <button class="btn btn-link p-0 text-danger">Reset All</button>
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-select form-select-sm">
                                    <option>Any Year</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                    <option>2022</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-select filter-dropdown">
                                    <option selected disabled>Make</option>
                                    <option>Porsche</option>
                                    <option>Ferrari</option>
                                    <option>BMW</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-select filter-dropdown">
                                    <option selected disabled>Model</option>
                                    <option>911</option>
                                    <option>Cayenne</option>
                                    <option>Macan</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-section">
                            <!-- Price Filter -->
                            <div class="filter-block mb-4">
                                <h4 class="p-18 fw-500 mb-4">Price</h4>
                                <div class="price-range-block">
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <input type="number" min="0" max="9900" oninput="validity.valid||(value='0');" id="min_price" placeholder="Min" class="form-control price-range-field" />
                                        </div>
                                        <div class="col-6">
                                            <input type="number" min="0" max="10000" oninput="validity.valid||(value='10000');" id="max_price" placeholder="Max" class="form-control price-range-field" />
                                        </div>
                                    </div>
                                    <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                                </div>
                            </div>
                            <!-- Mileage Filter -->
                            <div class="filter-block mb-3">
                                <h4 class="p-18 fw-500 mb-4">Mileage</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="mileage" id="m1">
                                    <label class="form-check-label" for="m1">Under 10,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="mileage" id="m2">
                                    <label class="form-check-label" for="m2">10,000 – 25,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="mileage" id="m3">
                                    <label class="form-check-label" for="m3">25,000 – 50,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="mileage" id="m4">
                                    <label class="form-check-label" for="m4">Over 50,000 miles</label>
                                </div>
                            </div>
                            <!-- Auction Status Filter -->
                            <div class="filter-block mb-3 border-bottom-0">
                                <h4 class="p-18 fw-500 mb-4">Auction Status</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="a1" checked>
                                    <label class="form-check-label" for="a1">Live Auction</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="a2">
                                    <label class="form-check-label" for="a2">Ending Soon</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="a3">
                                    <label class="form-check-label" for="a3">Reserve Met</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="a4">
                                    <label class="form-check-label" for="a4">Buy It Now</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="listing-toolbar">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="view-options">
                                    <span class="me-3 text-muted">View:</span>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-warning btn-sm active" data-view="grid-large">
                                            <i class="fas fa-th-large"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-view="list">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <label class="me-2 text-muted">Sort by:</label>
                                    <select class="form-select form-select-sm" style="width: auto;">
                                        <option>Ending Soon</option>
                                        <option>Price: Low to High</option>
                                        <option>Price: High to Low</option>
                                        <option>Year: Newest First</option>
                                        <option>Mileage: Low to High</option>
                                        <option>Most Watched</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Car Listings -->
                    <div class="car-listings" id="carListings">
                        <div class="row g-4" id="gridView">
                            <!-- Car Card 1 -->
                            @foreach($vehicles as $item)
                            @if($section=='Vehicles')
                            @include('components.guest.listing-card-vehicle')
                            @else
                            @include('components.guest.listing-card-auction')
                            @endif
                            @endforeach
                        </div>

                        <!-- List View (Hidden by default) -->
                        <div class="list-view d-none" id="listView">
                            <div class="car-list-item">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img src="https://placehold.co/300x200/1e293b/f8fafc?text=Porsche+911"
                                            class="img-fluid rounded" alt="Porsche 911">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-2">2021 Porsche 911 Turbo S</h5>
                                        <div class="fw-bold mb-2 current-bid">Current Bid: $185,000</div>
                                        <div class="d-flex gap-3 text-secondary small">
                                            <span><i class="fas fa-tachometer-alt me-1"></i>3,200 miles</span>
                                            <span><i class="fas fa-clock me-1"></i>Ends in 2d</span>
                                            <span><i class="fas fa-user me-1"></i>18 bids</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="d-flex flex-column gap-2">
                                            <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                            <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $vehicles->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>