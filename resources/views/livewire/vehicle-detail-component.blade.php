<div>
    <style>
        .accordion-button::after {
            --bs-accordion-btn-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            --bs-accordion-btn-active-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }
    </style>
    <div class="car-detail-page">
        <div class="container-fluid px-0">
            <!-- Main Content -->
            <div class="container mt-4">
                <div class="row g-4">
                    <div class="col-lg-8">
                        {{-- <div class="hero-gallery d-none">
                            <div class="main-image-container">
                                <img src="{{$mainImage ? asset('storage/'.$mainImage) : asset('images/default-car.webp')}}" alt="2023 Porsche 911 Turbo S" class="main-image" id="mainImage">
                        <div class="image-overlay">
                            @if ($selected_vehicle->live_auction && $selected_vehicle->is_auction)
                            <div class="auction-status">

                                <span class="status-badge live">LIVE AUCTION</span>

                            </div>
                            @endif
                            @if ($selected_vehicle->status == 'sold')
                            <div class="auction-status">

                                <span class="status-badge live">Sold</span>

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

                            @forelse($selected_vehicle->images as $image)
                            <img src="{{ asset('storage/'.$image->path) }}"
                                alt="Thumbnail"
                                class="thumbnail"
                                data-full="{{ asset('storage/'.$image->path) }}">
                            @empty
                            <img src="{{ asset('images/default-car.webp') }}"
                                alt="Thumbnail"
                                class="thumbnail"
                                data-full="{{ asset('images/default-car.webp') }}">
                            @endforelse

                        </div>
                    </div>
                </div> --}}
                        <div class="car-detail-images-wrap">
                            <div class="car-detail-slider-wrap">
                                {{-- Main slider --}}
                                <div class="swiper car-detail-slider2 mb-3">
                                    <div class="swiper-wrapper h-auto" id="animated-thumbnails">
                                        @forelse($selected_vehicle->images as $image)
                                            <a href="{{ asset('storage/' . $image->path) }}" class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="obj_fit" />
                                            </a>
                                        @empty
                                            <a href="{{ asset('images/default-car.webp') }}" class="swiper-slide">
                                                <img src="{{ asset('images/default-car.webp') }}" class="obj_fit" />
                                            </a>
                                        @endforelse
                                    </div>
                                    {{-- Auction status overlays --}}
                                    @if ($selected_vehicle->live_auction && $selected_vehicle->is_auction)
                                        <div class="auction-status">
                                            <span class="status-badge live">LIVE AUCTION</span>
                                        </div>
                                    @endif

                                    @if ($selected_vehicle->status == 'sold')
                                        <div class="auction-status">
                                            <span class="status-badge live">Sold</span>
                                        </div>
                                    @endif

                                    {{-- Fullscreen/gallery button --}}
                                    <button class="control-btn gallery-view" id="gallery-view">
                                        <i class="fas fa-expand"></i>
                                    </button>

                                    {{-- Swiper controls --}}
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-next">
                                        <i class="fa-sharp fa-solid fa-chevron-right"></i>
                                    </div>
                                    <div class="swiper-button-prev">
                                        <i class="fa-sharp fa-solid fa-chevron-left"></i>
                                    </div>
                                </div>
                                {{-- Thumbnails slider --}}
                                <div thumbsSlider="" class="swiper car-detail-slider">
                                    <div class="swiper-wrapper h-auto">
                                        @forelse($selected_vehicle->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="obj_fit" />
                                            </div>
                                        @empty
                                            <div class="swiper-slide">
                                                <img src="{{ asset('images/default-car.webp') }}" class="obj_fit" />
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-sections">
                            <div class="detail-sections accordion" id="vehicleDetailsAccordion">
                                <!-- Card 1: Car Details - OPEN -->
                                <div class="detail-card accordion-item">
                                    <div class="detail-header accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            <h3 class="detail-title mb-0"><i class="fas fa-car-side me-2"></i> Car
                                                Details</h3>
                                        </button>
                                    </div>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#vehicleDetailsAccordion">
                                        <div class="detail-content">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-calendar-alt"></i>
                                                        <div><span class="spec-label">Year</span><span
                                                                class="spec-value">{{ $selected_vehicle->year }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-tachometer-alt"></i>
                                                        <div><span class="spec-label">Mileage</span><span
                                                                class="spec-value">{{ $selected_vehicle->mileage . 'kms' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-cogs"></i>
                                                        <div><span class="spec-label">Transmission</span><span
                                                                class="spec-value">{{ $selected_vehicle->transmission?->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-gas-pump"></i>
                                                        <div><span class="spec-label">Fuel Type</span><span
                                                                class="spec-value">{{ $selected_vehicle->fuelType?->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-road"></i>
                                                        <div><span class="spec-label">Drivetrain</span><span
                                                                class="spec-value">{{ $selected_vehicle->drive_type }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="spec-item"><i class="fas fa-palette"></i>
                                                        <div><span class="spec-label">Color</span><span
                                                                class="spec-value">{{ $selected_vehicle->getColorLabelAttribute() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Car Description -->
                                <div class="detail-card accordion-item">
                                    <div class="detail-header accordion-header" id="headingSix">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="true"
                                            aria-controls="collapseSix">
                                            <h3 class="detail-title mb-0"><i class="fas fa-file-alt me-2"></i>Car
                                                Description</h3>
                                        </button>
                                    </div>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix" data-bs-parent="#vehicleDetailsAccordion">
                                        <div class="detail-content">
                                            <div class="row g-3">
                                                <div class="col-md-12 mx-2">
                                                    {{ $selected_vehicle->description ?? 'No Description Available' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2: Engine & Performance - OPEN -->
                                <div class="detail-card accordion-item">
                                    <div class="detail-header accordion-header" id="headingTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="true"
                                            aria-controls="collapseTwo">
                                            <h3 class="detail-title mb-0"><i class="fas fa-bolt me-2"></i> Engine &
                                                Performance</h3>
                                        </button>
                                    </div>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#vehicleDetailsAccordion">
                                        <div class="detail-content">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="detail-item"><span
                                                            class="detail-label">Engine</span><span
                                                            class="detail-value">{{ $selected_vehicle->engine_type }}</span>
                                                    </div>
                                                    <div class="detail-item"><span
                                                            class="detail-label">Horsepower</span><span
                                                            class="detail-value">{{ $selected_vehicle->horsepower }}HP</span>
                                                    </div>
                                                    <div class="detail-item"><span
                                                            class="detail-label">Torque</span><span
                                                            class="detail-value">{{ $selected_vehicle->torque }}
                                                            RPM</span></div>
                                                    <div class="detail-item"><span class="detail-label">No Of
                                                            Cylinders</span><span
                                                            class="detail-value">{{ $selected_vehicle->no_of_cylinder }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item"><span class="detail-label">0-60
                                                            mph</span><span
                                                            class="detail-value">{{ $selected_vehicle->zero_to_sixty }}
                                                            seconds</span></div>
                                                    <div class="detail-item"><span class="detail-label">Top
                                                            Speed</span><span
                                                            class="detail-value">{{ $selected_vehicle->top_speed }}
                                                            mph</span></div>
                                                    <div class="detail-item"><span class="detail-label">Quarter
                                                            Mile</span><span
                                                            class="detail-value">{{ $selected_vehicle->quater_mile }}
                                                            seconds</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Exterior Features -->
                                <div class="detail-card accordion-item">
                                    <div class="detail-header accordion-header" id="headingThree">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="true"
                                            aria-controls="collapseThree">
                                            <h3 class="detail-title mb-0"><i class="fas fa-car me-2"></i> Exterior
                                                Features</h3>
                                        </button>
                                    </div>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#vehicleDetailsAccordion">
                                        <div class="detail-content row">
                                            @foreach ($allexteriorFeatures as $feature)
                                                <div class="col-md-6 mb-2">
                                                    <i
                                                        class="fas {{ in_array($feature->name, $exteriorFeatures) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                                    {{ $feature->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Interior Features -->
                                <div class="detail-card accordion-item">
                                    <div class="detail-header accordion-header" id="headingFour">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="true"
                                            aria-controls="collapseFour">
                                            <h3 class="detail-title mb-0"><i class="fas fa-couch me-2"></i> Interior
                                                Features</h3>
                                        </button>
                                    </div>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour" data-bs-parent="#vehicleDetailsAccordion">
                                        <div class="detail-content row">
                                            @foreach ($allinteriorFeatures as $feature)
                                                <div class="col-md-6 mb-2">
                                                    <i
                                                        class="fas {{ in_array($feature->name, $interiorFeatures) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                                    {{ $feature->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-card">
                                <div class="detail-header">
                                    <h3 class="detail-title">
                                        <i class="fas fa-user-tie me-2"></i>
                                        Seller Information
                                    </h3>
                                </div>
                                <div class="detail-content">
                                    <div class="seller-info">
                                        <div class="seller-avatar">
                                            <img src="{{ asset('images/favicon@72x.ico') }}" alt="Seller">
                                        </div>
                                        <div class="seller-details">
                                            <h5>GoldenX</h5>
                                            <!-- <div class="seller-rating">
                                                <div class="stars">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span>(4.9/5 - 127 reviews)</span>
                                            </div> -->
                                            <p>Premium car company with 15+ years of experience. All vehicles come
                                                with
                                                detailed documentation and service records.</p>
                                            <!-- <div class="seller-stats">
                                                <div class="stat">
                                                    <span class="stat-number">47</span>
                                                    <span class="stat-label">Cars Sold</span>
                                                </div>
                                                <div class="stat">
                                                    <span class="stat-number">100%</span>
                                                    <span class="stat-label">Positive Feedback</span>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @if ($selected_vehicle->is_auction)
                            <!-- Contact Card -->
                            <div class="contact-card my-2">
                                <h4><i class="fas fa-phone"></i> Need Help?</h4>
                                <p>Our specialists are here to assist you</p>
                                <div class="contact-options">
                                    <a href="https://wa.me/+971545752757" class="btn btn-primary btn-bid">
                                        <i class="fab fa-whatsapp"></i>
                                        Whatsapp
                                    </a>
                                    <a href="mailto:info@thegoldenx.com" class="btn btn-outline-primary btn-auto-bid">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($selected_vehicle->is_auction)
                            <div id="bidding" class="sticky-sidebar">
                                @livewire('bidding-component', ['selected_vehicle' => $selected_vehicle])

                                <!-- Buy It Now Card -->

                            </div>
                            <div class="buy-now-card my-2">
                                <h4>Buy It Now</h4>
                                <div class="buy-now-price">{{ format_currency($selected_vehicle->price) }}</div>
                                <p>Skip the auction and purchase immediately</p>
                                @if (auth()->id())
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#buyNowModal">
                                        <i class="fas fa-shopping-cart"></i> Buy It Now
                                    </button>
                                    <a href="#bidding" class="btn btn-light">
                                        <i class="fas fa-gavel me-2"></i> Place Bid
                                    </a>
                                @else
                                    <a href="/login" class="btn btn-light text-primary ">

                                        <i class="fas fa-shopping-cart me-2"></i>Buy It Now <div class="spinner">
                                        </div>
                                    </a>
                                    <a href="#bidding" class="btn btn-light text-primary ">

                                        <i class="fas fa-gavel me-2"></i>Place Bid <div class="spinner"></div>
                                    </a>
                                @endif


                            </div>
                        @else
                            <div class="sticky-sidebar">
                                <!-- Contact Card -->

                                <div class="auction-card">
                                    <div class="auction-header">
                                        <h3 class="title-line-clamp-2">{{ $selected_vehicle->title }}</h3>
                                    </div>
                                    <div class="car-subtitle">
                                        @foreach ($tags as $feature)
                                            <span class="badge-custom">{{ $feature->name }}</span>
                                        @endforeach
                                    </div>
                                    <div class="current-bid">
                                        <span class="bid-label mb-0">Price</span>
                                        <span
                                            class="bid-amount">{{ format_currency($selected_vehicle->price) }}</span>

                                    </div>
                                    <div class="action-buttons mb-2">
                                        <livewire:favorite-button-detail-component :vehicleId="$selected_vehicle->id" />
                                        <!-- <button class="btn-icon" data-bs-toggle="tooltip" title="Share">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <button class="btn-icon" data-bs-toggle="tooltip" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button> -->
                                    </div>




                                </div>
                                <div class="contact-card">
                                    <h4><i class="fas fa-phone"></i> Need Help?</h4>
                                    <p>Our specialists are here to assist you</p>
                                     <div class="contact-options">
                                    <a href="https://wa.me/+971545752757" class="btn btn-primary btn-bid">
                                        <i class="fab fa-whatsapp"></i>
                                        Whatsapp
                                    </a>
                                    <a href="mailto:info@thegoldenx.com" class="btn btn-outline-primary btn-auto-bid">
                                        <i class="fas fa-envelope"></i>
                                        Email
                                    </a>
                                </div>
                                </div>
                                @if ($selected_vehicle->status !== 'sold')
                                    <div class="auction-card">
                                        @livewire('buy-car-component', ['selected_vehicle' => $selected_vehicle])
                                    </div>
                                @endif

                                <!-- Financing Card -->
                                <div class="financing-card">
                                    <h4><i class="fas fa-calculator"></i> Financing Calculator</h4>
                                    <div class="financing-form">

                                        <div class="form-group">
                                            <label>Total Vehicle Amount (AED)</label>
                                            <!-- Added id="totalAmountInput" -->
                                            <input type="number" class="form-control" id="totalAmountInput"
                                                placeholder="Total Vehicle Amount" step="500">
                                        </div>

                                        <div class="form-group">
                                            <label>Down Payment (AED)</label>
                                            <!-- Added id="downPaymentInput" -->
                                            <input type="number" class="form-control" id="downPaymentInput"
                                                placeholder="Down Payment" step="500">
                                        </div>

                                        <div class="form-group">
                                            <label>No of Insallments (Months)</label>
                                            <!-- Added id="installmentsInput" and changed default value to 48 -->
                                            <input type="number" class="form-control" placeholder="Insallments"
                                                id="installmentsInput">
                                        </div>

                                        <div class="form-group">
                                            <label>Annual Interest Rate (%)</label>
                                            <!-- Added new input for interest rate with an ID -->
                                            <input type="number" class="form-control" placeholder="Interest Rate"
                                                id="interestRateInput" step="0.1">
                                        </div>

                                        <div class="financing-result">
                                            <div class="monthly-payment">
                                                <span>Est. Monthly Payment</span>
                                                <!-- Added id="monthlyPaymentOutput" to the amount span -->
                                                <span class="amount" id="monthlyPaymentOutput">AED 0/mo</span>
                                            </div>
                                            <small>*This is an estimate. Final APR may vary based on credit.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript to make the calculator work -->


                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="buyNowModalLabel">Buy This Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @livewire('buy-car-component', ['selected_vehicle' => $selected_vehicle, 'is_auction' => 1])


                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('closeBuyNowModal', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('buyNowModal'));
                if (modal) modal.hide();
            });
        });
    </script>
    <script>
        // Wait for the document to be fully loaded before running the script
        document.addEventListener('DOMContentLoaded', function() {

            // Get references to all our HTML elements
            const totalAmountInput = document.getElementById('totalAmountInput');
            const downPaymentInput = document.getElementById('downPaymentInput');
            const installmentsInput = document.getElementById('installmentsInput');
            const interestRateInput = document.getElementById('interestRateInput');
            const monthlyPaymentOutput = document.getElementById('monthlyPaymentOutput');

            // Main function to calculate and display the payment
            function calculateMonthlyPayment() {
                // Get the values from the inputs, converting them to numbers
                const totalAmount = parseFloat(totalAmountInput.value) || 0;
                const downPayment = parseFloat(downPaymentInput.value) || 0;
                const installments = parseInt(installmentsInput.value) || 0;
                const annualRate = parseFloat(interestRateInput.value) || 0;

                // Calculate the total loan amount (principal)
                const principal = totalAmount - downPayment;

                // If there's nothing to finance or no term, the payment is 0
                if (principal <= 0 || installments <= 0) {
                    monthlyPaymentOutput.textContent = 'AED 0/mo';
                    return;
                }

                // Calculate monthly payment
                let monthlyPayment;

                if (annualRate === 0) {
                    // Simple case for 0% interest
                    monthlyPayment = principal / installments;
                } else {
                    // Convert annual rate to a monthly decimal rate
                    const monthlyInterestRate = annualRate / 100 / 12;

                    // Use the amortization formula
                    // M = P * [i(1+i)^n] / [(1+i)^n – 1]
                    const factor = Math.pow(1 + monthlyInterestRate, installments);
                    monthlyPayment = principal * (monthlyInterestRate * factor) / (factor - 1);
                }

                // Format the result nicely with commas and update the display
                const formattedPayment = monthlyPayment.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                monthlyPaymentOutput.textContent = `AED ${formattedPayment}/mo`;
            }

            // Add event listeners to all inputs to recalculate whenever they change
            totalAmountInput.addEventListener('input', calculateMonthlyPayment);
            downPaymentInput.addEventListener('input', calculateMonthlyPayment);
            installmentsInput.addEventListener('input', calculateMonthlyPayment);
            interestRateInput.addEventListener('input', calculateMonthlyPayment);

            // Perform an initial calculation when the page loads with the default values
            calculateMonthlyPayment();
        });
    </script>
</div>
