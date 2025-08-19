<div class="card">
    <div wire:loading wire:target="new_images">
        <x-full-page-loading />
    </div>

    <div class="card-header">
        <h5 class="mb-0">Manage Assets for: {{ $vehicle->title }}</h5>
    </div>
    <div class="card-body">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- File Upload Input --}}
        <div class="mb-3 border p-3 rounded bg-light">
            <label for="new_images" class="form-label fw-bold">Upload New Images</label>
            {{-- We use wire:model.live so the updatedNewImages hook runs instantly --}}
            <x-multi-image-uploader wire:model="new_images" :is_prev="false" />

            {{-- Shows a loading spinner while files are being uploaded --}}
            <div wire:loading wire:target="new_images" class="mt-2 text-primary">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Uploading...
            </div>
            @error('new_images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <hr class="my-4">

        {{-- Existing Images Gallery --}}
        <h6 class="mb-3">Existing Images</h6>
        <div class="row g-3">
            @forelse ($vehicle->images as $image)
            <div class="col-6 col-md-4 col-lg-3" wire:key="image-{{ $image->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="Vehicle Image" style="aspect-ratio: 4 / 3; object-fit: cover;">

                        {{-- Delete Button Overlay --}}
                        <button
                            class="btn btn-danger btn-sm rounded-circle"
                            wire:click="deleteImage({{ $image->id }})"
                            wire:confirm="Are you sure you want to delete this image?"
                            title="Delete Image"
                            style="width: 32px; height: 32px; position:absolute; right:0px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="card-body text-center p-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="cover_image_radio"
                                id="cover_{{ $image->id }}"
                                value="{{ $image->id }}"
                                wire:model.live="cover_image_id">
                            <label class="form-check-label fw-bold {{ $image->is_cover ? 'text-primary' : '' }}" for="cover_{{ $image->id }}">
                                {{ $image->is_cover ? 'Cover Image' : 'Set as Cover' }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted">No images have been uploaded for this vehicle yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>