<div class="container py-4">

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
            <h4>{{ $isEditing ? 'Edit Blog Post' : 'Add New Blog Post' }}</h4>
            <button class="btn btn-secondary" wire:click="cancel">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveBlog">
                <div class="row">
                    {{-- Left Column for Text Inputs --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model.live="title">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="10" wire:model.defer="content"></textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Right Column for Image and Meta --}}
                    <div class="col-md-4">
                        <div class="mb-3">

                            <!-- Image Upload -->
                            <div class="mb-3 position-relative">
                                <label for="image" class="form-label">Image</label>
                                <div class="position-relative">
                                    <x-filepond-input wire:model="image" allowImagePreview imagePreviewMaxHeight="200"
                                        allowFileTypeValidation acceptedFileTypes="['image/jpeg', 'image/png','image/jpg']"
                                        allowFileSizeValidation maxFileSize="20mb" />
                                </div>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mt-3">
                                @if ($isEditing && $editingBlog->image)
                                <p>Current Image:</p>
                                <img src="{{ asset('storage/' . $editingBlog->image) }}" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_published" wire:model.defer="is_published">
                            <label class="form-check-label" for="is_published">Publish Post</label>
                        </div>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="button" class="btn btn-secondary" wire:click="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="saveBlog">
                            {{ $isEditing ? 'Update Post' : 'Save Post' }}
                        </span>
                        <span wire:loading wire:target="saveBlog" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @else
    {{-- BLOGS LIST TABLE --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Blog Posts</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by title..." wire:model.live.debounce.300ms="search">
            </div>
            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add Post
            </button>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $index => $item)
                        <tr wire:key="blog-{{ $item->id }}">
                            <td>{{ $blogs->firstItem() + $index }}</td>
                            <td>

                                @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @if ($item->is_published)
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning text-dark">Draft</span>
                                @endif
                            </td>
                            <td>
                                <i class="fas fa-edit text-info me-2" style="cursor: pointer;" wire:click="editBlog({{ $item->id }})" title="Edit"></i>
                                <i class="fas fa-trash text-danger" style="cursor: pointer;" wire:click="$dispatch('confirmDelete', { id: {{ $item->id }} })" title="Delete"></i>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No blog posts found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $blogs->links() }}
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