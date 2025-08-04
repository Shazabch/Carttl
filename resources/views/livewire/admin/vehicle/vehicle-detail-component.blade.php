<div>
    @if(!$showForm)
    {{-- Page Header --}}
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">{{ $vehicle->year }} {{ $vehicle->brand?->name }} {{ $vehicle->vehicleModel?->name }}</h3>
                <small class="text-muted">{{ $vehicle->title }}</small>
            </div>
            <div>
                <button class="btn btn-sm btn-info" wire:click="editVehicle({{ $vehicle?->id }})"> <i class="fas fa-edit me-1"></i> Edit</button>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left Column for main details --}}
        <div class="col-lg-8">
            {{-- Basic Information Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Brand:</strong> {{ $vehicle->brand?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Model:</strong> {{ $vehicle->vehicleModel?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Variant:</strong> {{ $vehicle->variant ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Year:</strong> {{ $vehicle->year }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Condition:</strong> <span class="text-capitalize">{{ $vehicle->condition }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Mileage:</strong> {{ number_format($vehicle->mileage) }} mi</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Specifications Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Specifications</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Body Type:</strong> {{ $vehicle->bodyType?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fuel Type:</strong> {{ $vehicle->fuelType?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Transmission:</strong> {{ $vehicle->transmission?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Drive Type:</strong> {{ $vehicle->drive_type ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Engine (CC):</strong> {{ $vehicle->engine_cc ? number_format($vehicle->engine_cc) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Horsepower:</strong> {{ $vehicle->horsepower ? $vehicle->horsepower . ' hp' : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Torque:</strong> {{ $vehicle->torque ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Seats:</strong> {{ $vehicle->seats ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Doors:</strong> {{ $vehicle->doors ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Top Speed:</strong> {{ $vehicle->top_speed ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p>{{ $vehicle->description ?? 'No description provided.' }}</p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Exterior Features -->
                        <div class="col">
                            <h6 class="fw-bold">All Vehicle Tags</h6>
                            @if($tags->isNotEmpty())
                            <ul class="list-unstyled mb-3">
                                @foreach($tags as $tag)
                                <li>• {{ $tag->name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">No tag available.</p>
                            @endif
                        </div>

                      
                    </div>
                </div>
            </div>
              <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Features</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Exterior Features -->
                        <div class="col-md-6">
                            <h6 class="fw-bold">Exterior Features</h6>
                            @if($exteriorFeatures->isNotEmpty())
                            <ul class="list-unstyled mb-3">
                                @foreach($exteriorFeatures as $feature)
                                <li>• {{ $feature->name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">No exterior features available.</p>
                            @endif
                        </div>

                        <!-- Interior Features -->
                        <div class="col-md-6">
                            <h6 class="fw-bold">Interior Features</h6>
                            @if($interiorFeatures->isNotEmpty())
                            <ul class="list-unstyled mb-3">
                                @foreach($interiorFeatures as $feature)
                                <li>• {{ $feature->name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">No interior features available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column for pricing and status --}}
        <div class="col-lg-4">
            {{-- Pricing Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Pricing</h5>
                </div>
                <div class="card-body">
                    <h3 class="mb-2">${{ number_format($vehicle->price, 2) }}</h3>
                    @if($vehicle->negotiable)
                    <span class="badge bg-success">Price is Negotiable</span>
                    @else
                    <span class="badge bg-secondary">Price is Firm</span>
                    @endif
                </div>
            </div>

            {{-- Status & Identification Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Status & ID</h5>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-info text-white text-capitalize">{{ $vehicle->status }}</span></p>
                    <p><strong>Featured:</strong> {!! $vehicle->is_featured ? '<span class="badge bg-warning">Yes</span>' : 'No' !!}</p>
                    <hr>
                    <p><strong>VIN:</strong> {{ $vehicle->vin ?? 'N/A' }}</p>
                    <p><strong>Registration No:</strong> {{ $vehicle->registration_no ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>