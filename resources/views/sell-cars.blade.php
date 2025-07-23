@extends('layouts.guest')
@section('title')
    Car Auctions
@endsection
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
                            @include('components.guest.listing-card')

                            <!-- Car Card 2 -->


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
