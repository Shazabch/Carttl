@extends('account.layouts.app')
@section('title', 'Enquiries - Dashboard')
@section('dashboard-content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">My Enquiries</h5>
    </div>
    <div class="card-body">

        <!-- Toggle Buttons -->
        <ul class="nav nav-tabs mb-3" id="enquiryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="sale-tab" data-bs-toggle="tab" data-bs-target="#sale" type="button" role="tab">
                    Sale Enquiries
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="purchase-tab" data-bs-toggle="tab" data-bs-target="#purchase" type="button" role="tab">
                    Purchase Enquiries
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="enquiryTabsContent">

            <!-- Sale Enquiries -->
            <div class="tab-pane fade show active" id="sale" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name & Number</th>
                                <th>Email</th>
                                <th>Make & Model</th>
                                <th>Mileage</th>
                                <th>Images</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sale_enquiries as $enquiry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="">{{ $enquiry->name }}</div>
                                    <small class="text-muted">{{ $enquiry->phone }}</small>
                                </td>
                                <td>
                                    <div class="">{{ $enquiry->email }}</div>
                                </td>
                                <td>
                                    <div class="">{{ $enquiry->brand?->name ?? 'N/A' }}</div>
                                    
                                    <small class="text-dark">{{ $enquiry->vehicleModel?->name ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $enquiry->getMileageLabelAttribute() }}</td>
                                <td>
                                    @if($enquiry->vehicle)
                                    <div class="d-flex flex-wrap gap-1">
                                        <img src="{{ asset('storage/' . $enquiry->vehicle->coverImage->path) }}" width="40" height="40" class="rounded shadow-sm" style="object-fit: cover;" alt="Vehicle Image">
                                    </div>
                                    @else
                                    <span class="badge bg-secondary">No Images</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#details-{{ $enquiry->id }}" aria-expanded="false" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Details Row -->
                            <tr class="collapse" id="details-{{ $enquiry->id }}">
                                <td colspan="8" class="p-0">
                                    <div class="bg-light p-4">
                                        <div class="row g-4">
                                            <!-- Column 1: Enquiry Details -->
                                            <div class="col-lg-5">
                                                <h5 class="mb-3 border-bottom pb-2">Enquiry Details</h5>
                                                <dl class="row">
                                                    <dt class="col-sm-4">Full Name:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->name }}</dd>

                                                    <dt class="col-sm-4">Email:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->email ?? 'N/A' }}</dd>

                                                    <dt class="col-sm-4">Phone:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->phone }}</dd>

                                                    <dt class="col-sm-4">Make:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->brand?->name ?? 'N/A' }}</dd>

                                                    <dt class="col-sm-4">Model:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->vehicleModel?->name ?? 'N/A' }}</dd>

                                                    <dt class="col-sm-4">Year:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->year ?? 'N/A' }}</dd>

                                                    <dt class="col-sm-4">Mileage:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->getMileageLabelAttribute() }}</dd>

                                                    <dt class="col-sm-4">Specs:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->specification }}</dd>

                                                    @if($enquiry->notes)
                                                    <dt class="col-sm-4">Notes:</dt>
                                                    <dd class="col-sm-8">{{ $enquiry->notes }}</dd>
                                                    @endif
                                                </dl>
                                            </div>

                                            <!-- Column 2: Submitted Images -->
                                            <div class="col-lg-7">
                                                <h5 class="mb-3 border-bottom pb-2">Submitted Images</h5>
                                                @if($enquiry->imageSet)
                                                <div class="row g-2">
                                                    @foreach(range(1, 6) as $i)
                                                    @php $img = $enquiry->imageSet->{'image' . $i}; @endphp
                                                    @if($img)
                                                    <div class="col-4 col-md-3">
                                                        <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded shadow-sm" style="height: 100px; width: 100%; object-fit: cover;" alt="Vehicle Image {{ $i }}">
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                @else
                                                <p class="text-muted">No images were submitted with this enquiry.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-car-side fa-2x mb-2"></i>
                                    <p class="mb-0">No sale enquiries found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Purchase Enquiries -->
            <div class="tab-pane fade" id="purchase" role="tabpanel">
               <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name & Phone</th>
                <th>Email</th>
                <th>Vehicle</th>
                <th>Mileage</th>
                <th>Image</th>
                <th class="text-center">Date</th>
                <th class="text-center">View</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buy_enquiries as $enquiry)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <div class="">{{ $enquiry->name }}</div>
                    <small class="text-muted">{{ $enquiry->phone }}</small>
                </td>
                <td>{{ $enquiry->email ?? 'N/A' }}</td>
                <td>
                    <div class="">{{ $enquiry->vehicle?->title ?? 'N/A' }}</div>
                    <small class="text-dark">{{ $enquiry->vehicle?->year ?? 'N/A' }}</small>
                </td>
                <td>{{ $enquiry->getMileageLabelAttribute() ?? 'N/A' }}</td>
                <td>
                     @if($enquiry->vehicle)
                                    <div class="d-flex flex-wrap gap-1">
                                        <img src="{{ asset('storage/' . $enquiry->vehicle->coverImage->path) }}" width="40" height="40" class="rounded shadow-sm" style="object-fit: cover;" alt="Vehicle Image">
                                    </div>
                                    @else
                                    <span class="badge bg-secondary">No Images</span>
                                    @endif
                </td>
                <td class="text-center">{{ $enquiry->created_at->format('Y-m-d') }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#details-{{ $enquiry->id }}" 
                            aria-expanded="false" 
                            title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>

            <!-- Details Row -->
            <tr class="collapse" id="details-{{ $enquiry->id }}">
                <td colspan="8" class="p-0">
                    <div class="bg-light p-4">
                        <div class="row g-4">
                            <!-- Vehicle Details Column -->
                            <div class="col-lg-6">
                                <h5 class="mb-3 border-bottom pb-2">Vehicle Specifications</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Make/Model:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->vehicle?->title ?? 'N/A' }}</dd>
                                    
                                    <dt class="col-sm-4">Year:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->vehicle?->year ?? 'N/A' }}</dd>
                                    
                                    <dt class="col-sm-4">Price:</dt>
                                    <dd class="col-sm-8">{{ format_currency($enquiry->vehicle?->price) ?? 'N/A' }}</dd>
                                    
                                    <dt class="col-sm-4">Mileage:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->getMileageLabelAttribute() ?? 'N/A' }}</dd>
                                    
                                    <dt class="col-sm-4">VIN:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->vehicle?->vin ?? 'N/A' }}</dd>
                                </dl>
                            </div>

                            <!-- Customer Details Column -->
                            <div class="col-lg-6">
                                <h5 class="mb-3 border-bottom pb-2">Customer Details</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Full Name:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->name }}</dd>
                                    
                                    <dt class="col-sm-4">Phone:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->phone }}</dd>
                                    
                                    <dt class="col-sm-4">Email:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->email ?? 'N/A' }}</dd>
                                    
                                    <dt class="col-sm-4">Location:</dt>
                                    <dd class="col-sm-8">{{ $enquiry->address ?? 'N/A' }}</dd>
                                </dl>
                            </div>

                            <!-- Timeline Column -->
                            
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-car-side fa-2x mb-2"></i>
                    <p class="mb-0">No purchase enquiries found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>
</div>

@endsection