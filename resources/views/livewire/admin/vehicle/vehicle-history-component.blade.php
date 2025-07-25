<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Manage Vehicle History</h5>
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

    </div>
</div>