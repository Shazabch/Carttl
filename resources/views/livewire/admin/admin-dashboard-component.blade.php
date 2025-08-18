<div>
    <div class="container-fluid px-4">
        <div class="row g-4">

            <!-- Vehicle Management -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Total Vehicles</h5>
                            <h3 class="fw-bold mb-2">{{ $vehicleCount }}</h3>
                            <p class="card-text">Manage all vehicles in the system</p>
                            <a href="{{ route('admin.vehicles','all') }}" class="btn btn-sm btn-primary">Go to Vehicles</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-car"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspections -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Inspections</h5>
                            <h3 class="fw-bold mb-2">{{ $inspectionCount }}</h3>
                            <p class="card-text">Pending and completed inspections</p>
                            <a href="{{ route('admin.inspection.enquiries') }}" class="btn btn-sm btn-primary">View Inspections</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auctions -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Auctions</h5>
                            <h3 class="fw-bold mb-2">{{ $auctionCount }}</h3>
                            <p class="card-text">Active and upcoming vehicle auctions</p>
                            <a href="{{ route('admin.vehicles','all') }}" class="btn btn-sm btn-primary">Manage Auctions</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-gavel"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Listings -->
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Vehicle Listings</h5>
                            <h3 class="fw-bold mb-2">{{ $listingCount }}</h3>
                            <p class="card-text">All active and inactive listings</p>
                            <a href="{{ route('admin.vehicles','listed') }}" class="btn btn-sm btn-primary">View Listings</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-list-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sold Vehicles -->
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Sold Vehicles</h5>
                            <h3 class="fw-bold mb-2">{{ $soldVehicleCount }}</h3>
                            <p class="card-text">History of sold vehicles</p>
                            <a href="{{ route('admin.vehicles','sold') }}" class="btn btn-sm btn-primary">View Sold</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Enquiries -->
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Purchase Enquiries</h5>
                            <h3 class="fw-bold mb-2">{{ $purchaseenquiryCount }}</h3>
                            <p class="card-text">Check buyer requests and inquiries</p>
                            <a href="{{ route('admin.purchase.list') }}" class="btn btn-sm btn-primary">See Enquiries</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>