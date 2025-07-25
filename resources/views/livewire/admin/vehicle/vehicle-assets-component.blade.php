<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Manage Vehicle Assets</h5>
    </div>
    <div class="card-body">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- File Upload Form --}}
        <form wire:submit.prevent="save">
            <div class="mb-3">
                <label for="uploads" class="form-label">Upload New Photos</label>
                <input type="file" class="form-control" wire:model="uploads" multiple>
                @error('uploads.*') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <hr class="my-4">

        {{-- Existing Images Gallery --}}
        <h6>Existing Images</h6>
        <div class="row g-3">
            @if($vehicle->images)
            @forelse ($vehicle->images as $image)
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" alt="Vehicle Image">
                    {{-- You can add a delete button here --}}
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No images have been uploaded for this vehicle yet.</p>
                </div>
            @endforelse
            @endif
        </div>
    </div>
</div>