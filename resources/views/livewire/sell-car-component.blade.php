<div class="container my-4">

    @if ($formSubmitted)
        <div class="card shadow-lg border-0 rounded-lg text-center p-4 p-md-5">
            <div class="card-body">
                <div class="fa-4x text-success mb-4">
                    <i class="fas fa-check-circle fa-beat"></i>
                </div>
                <h1 class="display-5 fw-bold">Thank You!</h1>
                <p class="lead text-muted mt-3">
                    Your vehicle enquiry has been submitted successfully. We will be in touch shortly.
                </p>
                <hr class="my-4">
                <a href="{{ route('sell-car') }}" class="btn btn-outline-secondary mt-2" wire:navigate>
                    <i class="fas fa-plus-circle me-2"></i> Submit Another Enquiry
                </a>
            </div>
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-white text-center rounded-top-4 p-3">
                <h4 class="mb-0"><i class="fas fa-car me-2"></i> Sell Your Vehicle</h4>
            </div>
            <div class="card-body p-4 p-md-5">

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="progress" style="height: 30px;">
                        <div class="progress-bar bg-warning text-dark fw-bold" role="progressbar" style="width: {{ ($currentStep / 3) * 100 }}%;">
                            Step {{ $currentStep }} of 3
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="save" novalidate>
                    {{-- STEP 1: Personal Info --}}
                    @if ($currentStep === 1)
                        <div id="step-1">
                            <h5 class="text-center text-muted mb-4">Step 1: Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-user me-1 text-warning"></i> Full Name</label>
                                    <input type="text" wire:model.lazy="name" class="form-control" placeholder="Enter your full name">
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-phone me-1 text-warning"></i> Contact Number</label>
                                    <input type="text" wire:model.lazy="number" class="form-control" placeholder="Enter your contact number">
                                    @error('number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-envelope me-1 text-warning"></i>Email</label>
                                    <input type="email" wire:model.lazy="email" class="form-control" placeholder="Enter your Email">
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- STEP 2: Car Details --}}
                    @if ($currentStep === 2)
                        <div id="step-2">
                            <h5 class="text-center text-muted mb-4">Step 2: Vehicle Details</h5>
                            <div class="row g-3">
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
                                    <label class="form-label"><i class="fas fa-tachometer-alt me-1 text-warning"></i> Mileage (in km)</label>
                                    <input type="number" wire:model.lazy="mileage" class="form-control" placeholder="e.g., 35000">
                                    @error('mileage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-cogs me-1 text-warning"></i> Specification</label>
                                    <input type="text" wire:model.lazy="specification" class="form-control" placeholder="e.g., Automatic, Petrol, VXI">
                                    @error('specification') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-question-circle me-1 text-warning"></i> Common Question</label>
                                    <select wire:model.lazy="faq" class="form-select">
                                        <option value="">Select a Question</option>
                                        <option value="How do I sell my car?">How do I sell my car?</option>
                                        <option value="How long does it take?">How long does it take?</option>
                                        <option value="Do you offer Trade-In?">Do you offer Trade-In?</option>
                                        <option value="How is my car valued?">How is my car valued?</option>
                                    </select>
                                    @error('faq') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><i class="fas fa-sticky-note me-1 text-warning"></i> Additional Notes</label>
                                    <textarea wire:model.lazy="notes" class="form-control" rows="1" placeholder="Any additional notes..."></textarea>
                                    @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- STEP 3: Images --}}
                    @if ($currentStep === 3)
                        <div id="step-3">
                            <h5 class="text-center text-muted mb-4">Step 3: Upload Images</h5>
                            <div class="col-md-12" wire:ignore>
                                <label class="form-label"><i class="fas fa-images me-1 text-warning"></i> Vehicle Images (up to 6)</label>
                                <input type="file" wire:model="images" multiple id="imageUpload" class="filepond">
                            </div>
                             @error('images') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                             @error('images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        @if ($currentStep > 1)
                            <button type="button" class="btn btn-secondary" wire:click="previousStep">
                                <i class="fas fa-arrow-left me-2"></i> Previous
                            </button>
                        @else
                            <div></div> {{-- Empty div to keep "Next" on the right --}}
                        @endif

                        @if ($currentStep < 3)
                            <button type="button" class="btn btn-warning text-dark" wire:click="nextStep">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        @endif

                        @if ($currentStep === 3)
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading.remove wire:target="save">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Enquiry
                                </span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    Submitting...
                                </span>
                            </button>
                        @endif
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

        const pond = FilePond.create(document.querySelector('#imageUpload'), {
            storeAsFile: true, // Important for Livewire
            allowMultiple: true,
            maxFiles: 6,
            labelIdle: `Drag & Drop your images or <span class="filepond--label-action">Browse</span>`
        });

        // Clear after save
        Livewire.on('reset-filepond', () => {
            pond.removeFiles();
        });
    });
</script>
@endpush