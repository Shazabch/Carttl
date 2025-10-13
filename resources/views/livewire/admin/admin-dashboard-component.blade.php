<div>
    {{-- Define the user and the privileged status once, respecting the 'admin' guard. --}}
    @php
    $user = auth()->guard('admin')->user();
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));

    // Check if user has any of the permissions used below
    $hasAnyPermission =
    $isPrivilegedUser ||
    $user->can('vehicle-list') ||
    $user->can('inspection-list') ||
    $user->can('purchase-inquiry-list') ||
    $user->can('sale-inquiry-list');
    @endphp

    <div class="container-fluid px-4">
        @if ($hasAnyPermission)
        <div class="row g-4">

            @if ($isPrivilegedUser || $user->can('vehicle-list'))
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
            @endif

            @if ($isPrivilegedUser || $user->can('inspection-list'))
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
            @endif

            {{-- Assuming Auctions fall under general vehicle listing view --}}
            @if ($isPrivilegedUser || $user->can('vehicle-list'))
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
            @endif

            @if ($isPrivilegedUser || $user->can('vehicle-list'))
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
            @endif

            @if ($isPrivilegedUser || $user->can('vehicle-list'))
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
            @endif

            @if ($isPrivilegedUser || $user->can('purchase-inquiry-list'))
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
            @endif

            @if ($isPrivilegedUser || $user->can('sale-inquiry-list'))
            <div class="col-md-4 mt-3">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-dark">Sale Enquiries</h5>
                            <h3 class="fw-bold mb-2">{{ $sellenquiryCount }}</h3>
                            <p class="card-text">Check seller requests and inquiries</p>
                            <a href="{{ route('admin.sell.list') }}" class="btn btn-sm btn-primary">See Enquiries</a>
                        </div>
                        <div class="icon-container text-warning" style="font-size: 2.5rem;">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
        @else
        {{-- 🩵 Beautiful Note for No Permission --}}
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <div class="text-center">
                <i class="fas fa-lock text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-secondary fw-semibold">Access Restricted</h4>
                <p class="text-muted">
                    You currently don't have permission to view any dashboard modules.<br>
                    Please contact your administrator if you think this is a mistake.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>