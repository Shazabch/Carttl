<div>
    @php
    $user = auth()->guard('admin')->user();
    // Checks if the authenticated user has either 'super-admin' or 'admin' role.
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));
    @endphp

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-dark">Purchase Inquiries</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Name, Phone, Email..."
                    wire:model.live.debounce.300ms="search">
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
                            <th>Name & Phone</th>
                            <th>Email</th>
                            <th>Images</th>
                            <th>Vehicle</th>

                            <th class="text-center">Received</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseEnquiries as $enquiry)
                        <tr wire:key="enquiry-row-{{ $enquiry->id }}"
                            class="{{ $selectedEnquiryId === $enquiry->id ? 'table-primary' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $enquiry->name }}</div>
                                <small class="text-muted">{{ $enquiry->phone }}</small>
                            </td>
                            <td>{{ $enquiry->email ?? 'N/A' }}</td>
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
                            <td>{{ $enquiry->vehicle?->title ?? 'N/A' }}</td>

                            <td class="text-center">{{ $enquiry->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                @if ($isPrivilegedUser || $user->can('purchase-inquiry-view'))
                                <button class="btn btn-sm {{ $selectedEnquiryId === $enquiry->id ? 'btn-primary' : 'btn-outline-primary' }}"
                                    wire:click="viewDetails({{ $enquiry->id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @endif
                                @if ($isPrivilegedUser || $user->can('purchase-inquiry-delete'))
                                <button class="btn btn-sm btn-outline-danger"
                                    wire:click="$dispatch('confirmDelete', { id: {{ $enquiry->id }} })"
                                    title="Delete Inquiry">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- TOGGLEABLE DETAIL ROW --}}
                        @if ($selectedEnquiryId === $enquiry->id)
                        <tr wire:key="details-row-{{ $enquiry->id }}">
                            <td colspan="7" class="p-0">
                                <div class="bg-light p-4">
                                    <div class="row g-4">
                                        {{-- Column 1: Inquiry Details --}}
                                        <div class="col-12">
                                            <h5 class="mb-3 border-bottom pb-2">Vehicle Details</h5>
                                            <dl class="row">



                                                <dt class="col-sm-3">Vehicle:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->vehicle?->title ?? 'N/A' }}</dd>

                                                <dt class="col-sm-3">Price:</dt>
                                                <dd class="col-sm-9">{{ format_currency($enquiry->vehicle?->price) ?? 'N/A' }}</dd>







                                            </dl>
                                            <h6 class="mt-2 pt-2">Customer Details</h6>
                                            <dl class="row">
                                                <dt class="col-sm-3">Full Name:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->name }}</dd>


                                                <dt class="col-sm-3">Phone:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->phone }}</dd>

                                                <dt class="col-sm-3">Email:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->email ?? 'N/A' }}</dd>



                                                <dt class="col-sm-3">Address:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->address ?? 'N/A' }}</dd>



                                                <dt class="col-sm-3">Received At:</dt>
                                                <dd class="col-sm-9">{{ $enquiry->created_at->format('d M Y, h:i A') }}</dd>
                                            </dl>

                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-secondary mt-3"
                                        wire:click="viewDetails({{ $enquiry->id }})">Close Details</button>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-car-side fa-2x mb-2"></i>
                                <p class="mb-0">No purchase inquiries found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $purchaseEnquiries->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confirmDelete', (event) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This inquiry will be deleted permanently.",
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