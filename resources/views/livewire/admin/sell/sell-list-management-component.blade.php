<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-dark">Sale Enquiries</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Name, Number, Brand..." wire:model.live.debounce.300ms="search">
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name & Number</th>
                            <th>Email</th>
                            <th>Brand & Model</th>
                            <th>Mileage</th>
                            <th>Images</th>
                            <th class="text-center">Received</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($saleEnquiries as $enquiry)
                        <tr wire:key="enquiry-row-{{ $enquiry->id }}" class="{{ $selectedEnquiryId === $enquiry->id ? 'table-primary' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $enquiry->name }}</div>
                                <small class="text-muted">{{ $enquiry->number }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $enquiry->email }}</div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $enquiry->brand?->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $enquiry->vehicleModel?->name ?? 'N/A' }}</small>
                            </td>
                            <td>{{ number_format($enquiry->mileage) }} km</td>
                            <td>
                                @if($enquiry->imageSet)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(range(1, 3) as $i) {{-- Show first 3 images --}}
                                    @php $img = $enquiry->imageSet->{'image' . $i}; @endphp
                                    @if($img)
                                    <img src="{{ asset('storage/' . $img) }}" width="40" height="40" class="rounded shadow-sm" style="object-fit: cover;" alt="Vehicle Image">
                                    @endif
                                    @endforeach
                                </div>
                                @else
                                <span class="badge bg-secondary">No Images</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $enquiry->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm {{ $selectedEnquiryId === $enquiry->id ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="viewDetails({{ $enquiry->id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" wire:click="$dispatch('confirmDelete', { id: {{ $enquiry->id }} })" title="Delete Enquiry">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </td>
                        </tr>

                        {{-- TOGGLEABLE DETAIL ROW --}}
                        @if ($selectedEnquiryId === $enquiry->id)
                        <tr wire:key="details-row-{{ $enquiry->id }}">
                            <td colspan="7" class="p-0">
                                <div class="bg-light p-4">
                                    <div class="row g-4">
                                        {{-- Column 1: Enquiry Details --}}
                                        <div class="col-lg-5">
                                            <h5 class="mb-3 border-bottom pb-2">Enquiry Details</h5>
                                            <dl class="row">
                                                <dt class="col-sm-4">Full Name:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->name }}</dd>

                                                <dt class="col-sm-4">Number:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->number }}</dd>

                                                <dt class="col-sm-4">Brand:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->brand?->name ?? 'N/A' }}</dd>

                                                <dt class="col-sm-4">Model:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->vehicleModel?->name ?? 'N/A' }}</dd>

                                                <dt class="col-sm-4">Mileage:</dt>
                                                <dd class="col-sm-8">{{ number_format($enquiry->mileage) }} km</dd>

                                                <dt class="col-sm-4">Specification:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->specification }}</dd>

                                                <dt class="col-sm-4">FAQ:</dt>
                                                <dd class="col-sm-8 fst-italic">"{{ $enquiry->faq }}"</dd>

                                                @if($enquiry->notes)
                                                <dt class="col-sm-4">Notes:</dt>
                                                <dd class="col-sm-8">{{ $enquiry->notes }}</dd>
                                                @endif
                                            </dl>
                                        </div>

                                        {{-- Column 2: Submitted Images --}}
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
                                    <button class="btn btn-sm btn-secondary mt-3" wire:click="viewDetails({{ $enquiry->id }})">Close Details</button>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-car-side fa-2x mb-2"></i>
                                <p class="mb-0">No sale enquiries found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $saleEnquiries->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Listen for the 'livewire:initialized' event to ensure Livewire is ready
        document.addEventListener('livewire:initialized', () => {
            // Listen for the 'confirmDelete' event dispatched from the delete icon
            Livewire.on('confirmDelete', (event) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This enquiry will be deleted permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.delete(event.id);
                    }
                });
            });
        });
    </script>
    @endpush
</div>