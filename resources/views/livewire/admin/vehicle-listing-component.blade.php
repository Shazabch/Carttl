<div>
    @if (!$showForm)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Vehicles</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Title, VIN..." wire:model.live.debounce.300ms="search">
            </div>
            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add Vehicle
            </button>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Brand / Model</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                        <tr wire:key="{{ $vehicle->id }}">
                            <td>{{ $vehicle->title }}</td>
                            <td>{{ $vehicle->brand?->name }} / {{ $vehicle->vehicleModel?->name }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>${{ number_format($vehicle->price, 2) }}</td>
                            <td><span class="badge bg-primary text-white">{{ Str::ucfirst($vehicle->status) }}</span></td>
                            <td>
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
