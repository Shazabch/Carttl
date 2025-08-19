<div>
    @if (!$showForm)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Vehicles</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Title, VIN..." wire:model.live.debounce.300ms="search">
            </div>
           @if($type!='sold')
            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add Vehicle
            </button>
            @endif
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Make / Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                        <tr wire:key="{{ $vehicle->id }}">
                             <td>
                                @if($vehicle->coverImage)
                                <img
                                    src="{{ asset('storage/' . $vehicle->coverImage?->path) }}"
                                    alt="{{ $vehicle->title }}"
                                    class="rounded"
                                    style="width: 60px; height: 60px; object-fit: cover;"
                                >
                                @endif
                            </td>
                            <td>{{ $vehicle->title }}</td>
                            <td>{{ $vehicle->brand?->name }} / {{ $vehicle->vehicleModel?->name }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>{{ format_currency($vehicle->price) }}</td>
                            <td><span class="badge bg-primary text-white">{{ Str::ucfirst($vehicle->status) }}</span></td>
                            <td><span class="badge {{ $vehicle->is_auction ? "bg-dark":"bg-warning text-dark" }} text-white">{{ $vehicle->is_auction ? "Auction":"Vehicle" }}</span></td>
                            <td>
                                <!-- <a href="{{ route('admin.inspection.generate.from-vehicle', ['vehicle' => $vehicle->id]) }}" class="btn btn-sm btn-primary">
                                    Create Inspection
                                </a> -->
                                <a href="{{ route('admin.vehicles.details', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                <button class="btn btn-sm btn-info" wire:click="editVehicle({{ $vehicle->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" wire:click="$dispatch('confirmDelete', { id: {{ $vehicle->id }} })">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No vehicles found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $vehicles->links() }}
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('confirmDelete', ({
                id
            }) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This vehicle will be deleted permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.dispatch('deleteVehicle', {
                            id: id
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</div>