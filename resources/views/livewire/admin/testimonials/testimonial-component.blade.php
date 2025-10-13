<div class="container py-4">
    @php
    $user = auth()->guard('admin')->user();
    // Checks if the authenticated user has either 'super-admin' or 'admin' role.
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));
    @endphp

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($showForm)
    {{-- CREATE/EDIT FORM --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $isEditing ? 'Edit Testimonial' : 'Add New Testimonial' }}</h4>
            <button class="btn btn-secondary" wire:click="cancel">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveTestimonial">
                <div class="row">
                    {{-- Left Column for Text Inputs --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.live="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rank" class="form-label">Rank</label>
                            <input type="text" class="form-control @error('rank') is-invalid @enderror" id="rank" wire:model="rank">
                            @error('rank') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" rows="10" wire:model.defer="comment"></textarea>
                            @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Right Column for Image and Meta --}}
                    <div class="col-md-4">
                        <div class="mb-3">

                            <!-- Image Upload -->
                            <div class="mb-3 position-relative">
                                <label for="image_path" class="form-label">Image</label>
                                <div class="position-relative">
                                    <x-filepond-input wire:model="image_path" allowImagePreview imagePreviewMaxHeight="200"
                                        allowFileTypeValidation acceptedFileTypes="['image/jpeg', 'image/png','image/jpg']"
                                        allowFileSizeValidation maxFileSize="20mb" />
                                </div>
                                @error('image_path') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mt-3">
                                @if ($isEditing && $editingTestimonial->image)
                                <p>Current Image:</p>
                                <img src="{{ asset('storage/' . $editingTestimonial->image_path) }}" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" wire:model.defer="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="button" class="btn btn-secondary" wire:click="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="saveTestimonial">
                            {{ $isEditing ? 'Update ' : 'Save ' }}
                        </span>
                        <span wire:loading wire:target="saveTestimonial" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @else
    {{-- Testimonials LIST TABLE --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Testimonials</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by title..." wire:model.live.debounce.300ms="search">
            </div>
            @if ($isPrivilegedUser || $user->can('testimonial-manage'))
            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add New
            </button>
            @endif

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Rank</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $item)
                        <tr wire:key="blog-{{ $item->id }}">
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>

                                @if ($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->rank }}</td>
                            <td>{{ $item->comment }}</td>
                            <td>
                                @if ($item->status)
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning text-dark">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if ($isPrivilegedUser || $user->can('testimonial-manage'))
                                <i class="fas fa-edit text-info me-2" style="cursor: pointer;" wire:click="editTestimonial({{ $item->id }})" title="Edit"></i>
                                <i class="fas fa-trash text-danger" style="cursor: pointer;" wire:click="$dispatch('confirmDelete', { id: {{ $item->id }} })" title="Delete"></i>
                                @endif

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Listen for the 'livewire:initialized' event to ensure Livewire is ready
    document.addEventListener('livewire:initialized', () => {
        // Listen for the 'confirmDelete' event dispatched from the delete icon
        @this.on('confirmDelete', ({
            id
        }) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // If the user confirms, dispatch another event to the component to trigger the deletion
                if (result.isConfirmed) {
                    @this.dispatch('deleteItem', {
                        id: id
                    });
                }
            });
        });
    });
</script>
@endpush