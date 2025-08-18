<div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- <h5 class="mb-0">All inspections</h5> -->
            <input type="text" class="form-control w-25" placeholder="Search by name or email..." wire:model.live.debounce.300ms="search">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" wire:click="setSortBy('full_name')" style="cursor: pointer;">
                                Name <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('phone_number')" style="cursor: pointer;">
                                Phone <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('vehicle_type')" style="cursor: pointer;">
                                Type <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('email')" style="cursor: pointer;">
                                Email <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('created_at')" style="cursor: pointer;">
                                Received <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inspections as $item)
                        <tr wire:key="{{ $item->id }}">
                            <td>{{ $item->name }}</td>

                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->created_at->format('M d, Y H:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.inspection.generate.from-enquiry', ['enquiry' => $item->id]) }}" class="btn btn-sm btn-primary">
                                    Create Inspection
                                </a>
                                <button class="btn btn-sm btn-info" wire:click="view({{ $item->id }})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-danger"

                                    wire:click="$dispatch('confirmDeleteUser', { id: {{ $item->id }} })">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No inspections found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $inspections->links() }}
        </div>
    </div>

    {{-- View item Modal --}}
    @if ($showModal && isset($selectedEnquiry))
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-4">
                        <i class="fas fa-search-plus text-primary me-2"></i> Inspection Enquiry Details
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body pt-0">

                    <p class="text-muted mb-4">
                        Received on {{ $selectedEnquiry->created_at->format('F j, Y, g:i a') }}
                        ({{ $selectedEnquiry->created_at->diffForHumans() }})
                    </p>

                    <!-- Contact Information -->
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Contact Information</h6>
                    <div class="card bg-light border-0 p-3 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small">Full Name</label>
                                <p class="fw-bold mb-0 fs-5">{{ $selectedEnquiry->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Email Address</label>
                                <p class="mb-0"><a href="mailto:{{ $selectedEnquiry->email }}">{{ $selectedEnquiry->email }}</a></p>
                                <label class="form-label small mt-2">Phone</label>
                                <p class="mb-0"><a href="tel:{{ $selectedEnquiry->phone_number }}">{{ $selectedEnquiry->phone }}</a></p>
                            </div>
                        </div>
                    </div>


                    <!-- Appointment Details -->
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Appointment Details</h6>
                    <div class="card bg-light border-0 p-3 mb-4">
                        <div class="row">
                             <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label small"><i class="fas fa-calendar-alt mx-2"> </i>Preferred Date & Time</label>
                                <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($selectedEnquiry->date)->format('F j, Y') }} at {{ $selectedEnquiry->time }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small"><i class="fas fa-map-marker-alt mx-2"> </i>Location / Address</label>
                                <p class="mb-0">{{ $selectedEnquiry->location }}</p>
                            </div>
                        </div>
                    </div>


                    <!-- Vehicle Information -->
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Vehicle Information</h6>
                    <div class="card bg-light border-0 p-3">
                        <div class="row">
                            <div class="col-6 col-md-3 mb-2 mb-md-0">
                                <label class="form-label small">Vehicle Type</label>
                                <p class="fw-bold mb-0">{{ $selectedEnquiry->type }}</p>
                            </div>
                            <div class="col-6 col-md-3 mb-2 mb-md-0">
                                <label class="form-label small">Make</label>
                                <p class="fw-bold mb-0">{{ $selectedEnquiry->brand?->name }}</p>
                            </div>
                            
                            <div class="col-6 col-md-3">
                                <label class="form-label small">Model</label>
                                <p class="fw-bold mb-0">{{ $selectedEnquiry->vehicleModel?->name }}</p>
                            </div>
                             <div class="col-6 col-md-3">
                                <label class="form-label small">Model Year</label>
                                <p class="fw-bold mb-0">{{ $selectedEnquiry->year }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // Event listener for delete confirmation
            Livewire.on('confirmDeleteUser', (event) => {
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