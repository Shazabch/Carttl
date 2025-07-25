<div class="container my-4">

    @if ($formSubmitted)
        <div class="card shadow-lg border-0 rounded-lg text-center p-4 p-md-5">
            <div class="card-body">
                <div class="fa-4x text-success mb-4">
                    <i class="fas fa-check-circle fa-beat"></i>
                </div>
                <h1 class="display-5 fw-bold">Thank You!</h1>
                <p class="lead text-muted mt-3">
                    Your vehicle has been added successfully.
                </p>
                <hr class="my-4">
                <p>Want to add another car?</p>

                <a href="{{ route('sell-car') }}" class="btn btn-outline-secondary mt-2">
                    <i class="fas fa-car me-2"></i> Add Another Vehicle
                </a>
            </div>
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-white text-center rounded-top-4">
                <h4 class="mb-0"><i class="fas fa-car me-2"></i> Vehicle Information</h4>
            </div>
            <div class="card-body p-4">
                <form wire:submit.prevent="save" enctype="multipart/form-data" novalidate>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-user me-1 text-warning"></i> Name</label>
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Owner name">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-hashtag me-1 text-warning"></i> Number</label>
                            <input type="number" wire:model.lazy="number" class="form-control" placeholder="Vehicle number">
                            @error('number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-industry me-1 text-warning"></i> Brand</label>
                            <select class="form-select" wire:model.live="brand_id">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-car-side me-1 text-warning"></i> Model</label>
                            <select class="form-select" wire:model.defer="make_id">
                                <option value="">Select Model</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            @error('make_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-tachometer-alt me-1 text-warning"></i> Mileage</label>
                            <input type="number" wire:model.lazy="mileage" class="form-control" placeholder="e.g. 35000 km">
                            @error('mileage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-cogs me-1 text-warning"></i> Specification</label>
                            <input type="text" wire:model.lazy="specification" class="form-control" placeholder="e.g. Automatic, Petrol">
                            @error('specification') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-question-circle me-1 text-warning"></i> FAQ
                            </label>
                            <select wire:model.lazy="faq" class="form-select" style="border-radius: 12px; border: 1.5px solid #2a3d53;">
                                <option value="">Select FAQ</option>
                                <option value="How do I sell my car?">How do I sell my car?</option>
                                <option value="How long does it take?">How long does it take?</option>
                                <option value="Do you offer Trade-In?">Do you offer Trade-In?</option>
                                <option value="How is my car valued?">How is my car valued?</option>
                            </select>
                            @error('faq') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-sticky-note me-1 text-warning"></i> Notes</label>
                            <textarea wire:model.lazy="notes" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                            @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12" wire:ignore>
                            <label class="form-label"><i class="fas fa-images me-1 text-warning"></i> Images (max 6)</label>
                            <input
                            type="file"
                            wire:model="images"
                            multiple
                            id="imageUpload"
                            class="filepond"
                        >
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-warning text-dark px-4" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-paper-plane me-2"></i> Submit
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        FilePond.registerPlugin(FilePondPluginImagePreview);

        const input = document.querySelector('#imageUpload');

        const pond = FilePond.create(input, {
            allowMultiple: true,
            maxFiles: 6
        });

        // Clear after save
        window.Livewire.on('reset-filepond', () => {
            pond.removeFiles();
        });
    });
</script>
@endpush