@extends('layouts.guest')
@section('title')
    Car Auctions
@endsection
<style>
    /* ===== CAR LISTING SECTION ===== */
    .car-listing-section {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .listing-header {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .listing-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .listing-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        margin: 0;
    }

    .results-count {
        color: #64748b;
        font-weight: 500;
    }

    /* ===== FILTERS SIDEBAR ===== */
    .filters-sidebar {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 2rem;
        max-height: calc(100vh - 4rem);
        overflow-y: auto;
    }

    .filters-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .filters-header h4 {
        color: #0f172a;
        font-weight: 600;
        margin: 0;
    }

    .filter-group {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-group:last-child {
        border-bottom: none;
    }

    .filter-title {
        color: #0f172a;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .filter-options .form-check {
        margin-bottom: 0.5rem;
    }

    .filter-options .form-check-label {
        color: #475569;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-options .count {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .form-check-input:checked {
        background-color: #f59e0b;
        border-color: #f59e0b;
    }

    .form-range::-webkit-slider-thumb {
        background: #f59e0b;
    }

    .form-range::-moz-range-thumb {
        background: #f59e0b;
        border: none;
    }

    /* ===== LISTING TOOLBAR ===== */
    .listing-toolbar {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .view-options .btn-group .btn {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .view-options .btn-group .btn.active {
        background-color: #f59e0b;
        color: #0f172a;
    }

    /* ===== CAR CARDS ===== */
    .car-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .car-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .car-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .car-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        z-index: 2;
    }

    .car-badge.hot {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .car-badge.ending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .car-badge.reserve {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .wishlist-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .wishlist-btn:hover {
        background: white;
        transform: scale(1.1);
    }

    .wishlist-btn.active {
        background: #f59e0b;
        color: white;
    }

    .current-bid {
        color: #f59e0b !important;
    }

    .car-card .card-title {
        color: #0f172a;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* ===== LIST VIEW ===== */
    .car-list-item {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .car-list-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    /* ===== PAGINATION ===== */
    .pagination .page-link {
        color: #f59e0b;
        border-color: #e2e8f0;
    }

    .pagination .page-item.active .page-link {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #0f172a;
    }

    .pagination .page-link:hover {
        color: #d97706;
        background-color: rgba(245, 158, 11, 0.1);
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 992px) {
        .filters-sidebar {
            position: static;
            margin-bottom: 2rem;
        }

        .listing-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .car-listing-section {
            padding: 1rem 0;
        }

        .listing-header {
            padding: 1.5rem;
        }

        .listing-toolbar {
            padding: 1rem;
        }

        .view-options {
            margin-bottom: 1rem;
        }

        .car-card .card-img-top {
            height: 180px;
        }
    }
</style>
@section('content')
    <div class="car-listing-section">
        <div class="container-fluid">
            <!-- Header Section -->


            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3">
                    <div class="filters-sidebar">
                        <div class="filters-header">
                            <h4><i class="fas fa-filter me-2"></i>Filters</h4>
                            <button class="btn btn-link btn-sm text-warning p-0">Clear All</button>
                        </div>

                        <!-- Price Range Filter -->
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
                            <select class="form-select form-select-sm">
                                <option>Any Year</option>
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                                <option>2020</option>
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
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Toolbar -->
                    <div class="listing-toolbar">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="view-options">
                                    <span class="me-3 text-muted">View:</span>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-warning btn-sm active"
                                            data-view="grid-large">
                                            <i class="fas fa-th-large"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-view="grid">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm"
                                            data-view="grid-small">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-view="list">
                                            <i class="fas fa-list"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-view="table">
                                            <i class="fas fa-table"></i>
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
                            <div class="col-md-6 col-lg-4">
                                <div class="card car-card position-relative h-100">
                                    <img src="https://placehold.co/600x400/1e293b/f8fafc?text=Porsche+911"
                                        class="card-img-top" alt="Porsche 911">
                                    <div class="car-badge hot">Hot Bid</div>
                                    <div class="wishlist-btn">
                                        <i class="far fa-heart"></i>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">2021 Porsche 911 Turbo S</h5>
                                        <div class="fw-bold mb-2 current-bid">Current Bid: $185,000</div>
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

                            <!-- Car Card 2 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card car-card position-relative h-100">
                                    <img src="https://placehold.co/600x400/1e293b/f8fafc?text=Ferrari+488"
                                        class="card-img-top" alt="Ferrari 488">
                                    <div class="car-badge ending">Ending Soon</div>
                                    <div class="wishlist-btn active">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">2020 Ferrari 488 GTB</h5>
                                        <div class="fw-bold mb-2 current-bid">Current Bid: $275,500</div>
                                        <div class="d-flex justify-content-between text-secondary small mb-3">
                                            <span><i class="fas fa-tachometer-alt me-1"></i>8,450 miles</span>
                                            <span><i class="fas fa-clock me-1"></i>Ends in 4h</span>
                                            <span><i class="fas fa-user me-1"></i>32 bids</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                            <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Car Card 3 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card car-card position-relative h-100">
                                    <img src="https://placehold.co/600x400/1e293b/f8fafc?text=BMW+M4" class="card-img-top"
                                        alt="BMW M4">
                                    <div class="car-badge reserve">Reserve Met</div>
                                    <div class="wishlist-btn">
                                        <i class="far fa-heart"></i>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">2022 BMW M4 Competition</h5>
                                        <div class="fw-bold mb-2 current-bid">Current Bid: $78,900</div>
                                        <div class="d-flex justify-content-between text-secondary small mb-3">
                                            <span><i class="fas fa-tachometer-alt me-1"></i>12,300 miles</span>
                                            <span><i class="fas fa-clock me-1"></i>Ends in 1d</span>
                                            <span><i class="fas fa-user me-1"></i>9 bids</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="btn btn-warning btn-sm">View Details</a>
                                            <a href="#" class="btn btn-outline-warning btn-sm">Watch</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add more car cards as needed -->
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

                    <!-- Pagination -->
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">21</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    // ===== VIEW SWITCHING FUNCTIONALITY ===== 
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('[data-view]');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                viewButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const view = this.getAttribute('data-view');

                switch (view) {
                    case 'grid-large':
                        gridView.className = 'row g-4';
                        gridView.querySelectorAll('.col-md-6').forEach(col => {
                            col.className = 'col-lg-6';
                        });
                        showGridView();
                        break;
                    case 'grid':
                        gridView.className = 'row g-4';
                        gridView.querySelectorAll('.col-lg-6').forEach(col => {
                            col.className = 'col-md-6 col-lg-4';
                        });
                        showGridView();
                        break;
                    case 'grid-small':
                        gridView.className = 'row g-3';
                        gridView.querySelectorAll('.col-md-6').forEach(col => {
                            col.className = 'col-md-4 col-lg-3';
                        });
                        showGridView();
                        break;
                    case 'list':
                        showListView();
                        break;
                    case 'table':
                        // Implement table view
                        showGridView();
                        break;
                }
            });
        });

        function showGridView() {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
        }

        function showListView() {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');
        }
    });
</script>
