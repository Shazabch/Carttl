<div>
    @if (!$showForm)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Makes</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Make Name..."
                    wire:model.live.debounce.300ms="search">
            </div>

            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add Make
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Make Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($makes as $make)
                        <tr wire:key="make-{{ $make->id }}">
                            <td>{{ $makes->firstItem() + $loop->index }}</td>

                            <td>{{ $make->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" wire:click="editMake({{ $make->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No makes found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $makes->links() }}
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('confirmDeleteMake', ({
            id
        }) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "This make will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('deleteMake', {
                        id: id
                    });
                }
            });
        });
    });
    </script>
    @endpush
</div>