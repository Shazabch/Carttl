<div>
    <div class="car-listing-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">

                    <div class="filter-box">
                        <div class="bx-white mb-4">
                            <div class="filter-header d-flex justify-content-between align-items-center mb-3">
                                <h5>Filters</h5>
                                <button wire:click="resetAll()" class="btn btn-link p-0 text-danger">
                                    Reset All
                                </button>
                            </div>
                            <div class="form-group mb-3">
                                <select wire:model.live="year" class="form-select form-select-sm">
                                    <option>Any Year</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                    <option>2022</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <select wire:model.live="make" class="form-select">
                                    <option value="">Any Make</option>
                                    @foreach($brands as $makes)
                                    <option value="{{$makes->id}}">{{$makes->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <select wire:model.live="model" class="form-select">
                                    <option value="">Any Model</option>
                                    @foreach($models as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                    @endforeach
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
                                            <input type="number" wire:model.live="minPrice" min="0" max="9900" oninput="validity.valid||(value='0');" id="min_price" placeholder="Min" class="form-control price-range-field" />
                                        </div>
                                        <div class="col-6">
                                            <input type="number" wire:model.live="maxPrice" min="0" max="1000000000" oninput="validity.valid||(value='1000000000');" id="max_price" placeholder="Max" class="form-control price-range-field" />
                                        </div>
                                    </div>
                                    <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                                </div>
                            </div>
                            <!-- Mileage Filter -->
                            <div class="filter-block mb-3">
                                <h4 class="p-18 fw-500 mb-4">Mileage</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="mileage" value="under10k" type="radio" name="mileage" id="m1">
                                    <label class="form-check-label" for="m1">Under 10,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="mileage" value="10k-25k" type="radio" name="mileage" id="m2">
                                    <label class="form-check-label" for="m2">10,000 – 25,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="mileage" value="25k-50k" type="radio" name="mileage" id="m3">
                                    <label class="form-check-label" for="m3">25,000 – 50,000 miles</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="mileage" value="over50k" type="radio" name="mileage" id="m4">
                                    <label class="form-check-label" for="m4">Over 50,000 miles</label>
                                </div>
                            </div>
                            <!-- Auction Status Filter -->
                            <div class="filter-block mb-3 border-bottom-0">
                                <h4 class="p-18 fw-500 mb-4">Auction Status</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="live_auction" value="live_auction" type="checkbox" id="a1" checked>
                                    <label class="form-check-label" for="a1">Live Auction</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" wire:model.live="endingSoon" value="endingSoon" type="checkbox" id="a2">
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
                                    <select wire:model.live="sortBy" class="form-select form-select-sm" style="width: auto;">
                                        <option value="ending_soon">Ending Soon</option>
                                        <option value="price_low_high">Price: Low to High</option>
                                        <option value="price_high_low">Price: High to Low</option>
                                        <option value="year_newest">Year: Newest First</option>
                                        <option value="mileage_low_high">Mileage: Low to High</option>
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
                             @foreach($vehicles as $item)
                            @if($section=='Vehicles')
                            @include('components.guest.listing-card-vehicle-list-view')
                            @else
                            @include('components.guest.listing-card-auction-list-view')
                            @endif
                            @endforeach
                            <!-- <div class="car-list-item">
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
                            </div> -->
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