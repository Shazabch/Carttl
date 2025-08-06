<div>
    <div class="car-detail-page">
        <div class="container-fluid px-0">
            <!-- Main Content -->
            <div class="container mt-4">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="hero-gallery">
                            <div class="main-image-container">
                                <img src="{{$mainImage ? asset('storage/'.$mainImage) : asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp')}}" alt="2023 Porsche 911 Turbo S" class="main-image" id="mainImage">
                                <div class="image-overlay">
                                    @if($selected_vehicle->live_auction)
                                    <div class="auction-status">

                                        <span class="status-badge live">LIVE AUCTION</span>


                                        <div class="time-remaining">
                                            <i class="fas fa-clock"></i>
                                            <span id="countdown">2d 14h 32m</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="image-controls">
                                        <button class="control-btn" id="prevImage"><i
                                                class="fas fa-chevron-left"></i></button>
                                        <button class="control-btn" id="nextImage"><i
                                                class="fas fa-chevron-right"></i></button>
                                        <button class="control-btn fullscreen-btn" id="fullscreenBtn"><i
                                                class="fas fa-expand"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-gallery">
                                <div class="thumbnail-container">

                                    @foreach($selected_vehicle->images as $image)
                                    <img src="{{asset('storage/'.$image->path)}}" alt="Thumbnail" class="thumbnail"
                                        data-full="{{asset('storage/'.$image->path)}}">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="detail-sections">
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        Car Details
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-calendar-alt"></i>
                                                <div>
                                                    <span class="spec-label">Year</span>
                                                    <span class="spec-value">{{$selected_vehicle->year}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-tachometer-alt"></i>
                                                <div>
                                                    <span class="spec-label">Mileage</span>
                                                    <span class="spec-value">{{$selected_vehicle->mileage}} miles</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-cogs"></i>
                                                <div>
                                                    <span class="spec-label">Transmission</span>
                                                    <span
                                                        class="spec-value">{{$selected_vehicle->transmission?->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-gas-pump"></i>
                                                <div>
                                                    <span class="spec-label">Fuel Type</span>
                                                    <span
                                                        class="spec-value">{{$selected_vehicle->fuelType?->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-road"></i>
                                                <div>
                                                    <span class="spec-label">Drivetrain</span>
                                                    <span class="spec-value">{{$selected_vehicle->drive_type}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="spec-item">
                                                <i class="fas fa-palette"></i>
                                                <div>
                                                    <span class="spec-label">Color</span>
                                                    <span class="spec-value">{{$selected_vehicle->getColorLabelAttribute()}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        Engine & Performance
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <span class="detail-label">Engine</span>
                                                <span class="detail-value">{{$selected_vehicle->engine_type}}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Horsepower</span>
                                                <span class="detail-value">{{$selected_vehicle->horsepower}}HP</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Torque</span>
                                                <span class="detail-value">{{$selected_vehicle->torque}} RPM</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <span class="detail-label">0-60 mph</span>
                                                <span class="detail-value">{{$selected_vehicle->zero_to_sixty}} seconds</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Top Speed</span>
                                                <span class="detail-value">{{$selected_vehicle->top_speed}} mph</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Quarter Mile</span>
                                                <span class="detail-value">{{$selected_vehicle->quater_mile}} seconds</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        <i class="fas fa-car"></i>
                                        Exterior Features
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="feature-grid">
                                        @foreach($allexteriorFeatures as $feature)
                                        <div class="feature-item">
                                            @if(in_array($feature->name, $exteriorFeatures))
                                            <i class="fas fa-check-circle"></i>
                                            @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            <span>{{$feature->name}}</span>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        <i class="fas fa-couch"></i>
                                        Interior Features
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="feature-grid">
                                        @foreach($allinteriorFeatures as $feature)
                                        <div class="feature-item">
                                            @if(in_array($feature->name, $interiorFeatures))
                                            <i class="fas fa-check-circle"></i>
                                            @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            <span>{{$feature->name}}</span>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        <i class="fas fa-history"></i>
                                        Vehicle History
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="history-timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h5>Vehicle Purchased New</h5>
                                                <p>March 2023 - Porsche Beverly Hills</p>
                                                <span class="timeline-badge">Original Owner</span>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h5>First Service</h5>
                                                <p>September 2023 - 1,200 miles</p>
                                                <span class="timeline-badge">Authorized Dealer</span>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h5>Clean Title</h5>
                                                <p>No accidents or damage reported</p>
                                                <span class="timeline-badge success">Verified</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        <i class="fas fa-user-tie"></i>
                                        Seller Information
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="seller-info">
                                        <div class="seller-avatar">
                                            <img src="{{ asset('images/favicon@72x.ico') }}"
                                                alt="Seller">
                                        </div>
                                        <div class="seller-details">
                                            <h5>Admin</h5>
                                            <div class="seller-rating">
                                                <div class="stars">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span>(4.9/5 - 127 reviews)</span>
                                            </div>
                                            <p>Premium car collector with 15+ years of experience. All vehicles come
                                                with
                                                detailed documentation and service records.</p>
                                            <div class="seller-stats">
                                                <div class="stat">
                                                    <span class="stat-number">47</span>
                                                    <span class="stat-label">Cars Sold</span>
                                                </div>
                                                <div class="stat">
                                                    <span class="stat-number">100%</span>
                                                    <span class="stat-label">Positive Feedback</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @if($selected_vehicle->is_auction)
                        <div class="sticky-sidebar">
                            @livewire('bidding-component',['selected_vehicle' => $selected_vehicle])

                            <!-- Buy It Now Card -->
                            <div class="buy-now-card">
                                <h4>Buy It Now</h4>
                                <div class="buy-now-price">{{format_currency($selected_vehicle->price)}}</div>
                                <p>Skip the auction and purchase immediately</p>
                                <button class="btn btn-warning btn-buy-now">
                                    <i class="fas fa-shopping-cart"></i>
                                    Buy It Now
                                </button>
                            </div>

                            <!-- Financing Card -->
                            <div class="financing-card">
                                <h4><i class="fas fa-calculator"></i> Financing Calculator</h4>
                                <div class="financing-form">
                                    <div class="form-group">
                                        <label>Loan Amount</label>
                                        <input type="number" class="form-control" value="185500">
                                    </div>
                                    <div class="form-group">
                                        <label>Down Payment</label>
                                        <input type="number" class="form-control" value="37100">
                                    </div>
                                    <div class="form-group">
                                        <label>Term (months)</label>
                                        <select class="form-select">
                                            <option>36</option>
                                            <option>48</option>
                                            <option selected>60</option>
                                            <option>72</option>
                                        </select>
                                    </div>
                                    <div class="financing-result">
                                        <div class="monthly-payment">
                                            <span>Est. Monthly Payment</span>
                                            <span class="amount">$2,847/mo</span>
                                        </div>
                                        <small>*Based on 4.9% APR for qualified buyers</small>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-bid w-100">Get Pre-Approved</button>
                            </div>

                            <!-- Contact Card -->
                            <div class="contact-card">
                                <h4><i class="fas fa-phone"></i> Need Help?</h4>
                                <p>Our specialists are here to assist you</p>
                                <div class="contact-options">
                                    <button class="btn btn-primary btn-bid">
                                        <i class="fas fa-phone"></i>
                                        Call Now
                                    </button>
                                    <button class="btn btn-outline-primary btn-auto-bid">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </button>
                                </div>
                            </div>
                        </div>

                        @else
                        <div class="sticky-sidebar">
                            <div class="auction-card">
                                <div class="auction-header">
                                    <h3>{{$selected_vehicle->title}}</h3>
                                </div>
                                <div class="car-subtitle">
                                    @foreach($tags as $feature)
                                    <span class="badge-custom">{{$feature->name}}</span>
                                    @endforeach
                                </div>
                                <div class="current-bid">
                                    <span class="bid-label mb-0">Price</span>
                                    <span class="bid-amount">{{format_currency($selected_vehicle->price)}}</span>

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




                            </div>
                            <div class="auction-card">
                                @livewire('buy-car-component',['selected_vehicle' => $selected_vehicle])
                            </div>



                            <!-- Financing Card -->
                            <div class="financing-card">
                                <h4><i class="fas fa-calculator"></i> Financing Calculator</h4>
                                <div class="financing-form">
                                    <div class="form-group">
                                        <label>Loan Amount</label>
                                        <input type="number" class="form-control" value="185500">
                                    </div>
                                    <div class="form-group">
                                        <label>Down Payment</label>
                                        <input type="number" class="form-control" value="37100">
                                    </div>
                                    <div class="form-group">
                                        <label>Term (months)</label>
                                        <select class="form-select">
                                            <option>36</option>
                                            <option>48</option>
                                            <option selected>60</option>
                                            <option>72</option>
                                        </select>
                                    </div>
                                    <div class="financing-result">
                                        <div class="monthly-payment">
                                            <span>Est. Monthly Payment</span>
                                            <span class="amount">$2,847/mo</span>
                                        </div>
                                        <small>*Based on 4.9% APR for qualified buyers</small>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-bid w-100">Get Pre-Approved</button>
                            </div>

                            <!-- Contact Card -->
                            <div class="contact-card">
                                <h4><i class="fas fa-phone"></i> Need Help?</h4>
                                <p>Our specialists are here to assist you</p>
                                <div class="contact-options">
                                    <button class="btn btn-primary btn-bid">
                                        <i class="fas fa-phone"></i>
                                        Call Now
                                    </button>
                                    <button class="btn btn-outline-primary btn-auto-bid">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </button>
                                </div>
                            </div>
                        </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>