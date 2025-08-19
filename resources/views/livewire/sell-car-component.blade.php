<div class="">
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
    <div class="sell-your-car">
        <h4 class="h-28 mb-4 fw-600">Sell Your Vehicle</h4>
        <div class="custom-progress mb-5">
            <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3.13 11L5 6.92A2 2 0 0 1 6.78 6h10.44a2 2 0 0 1 1.78.92L21 11v8a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8Zm2.39 0h12.96l-1.27-2.54a.5.5 0 0 0-.44-.26H7.23a.5.5 0 0 0-.44.26L5.52 11ZM7 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm10 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                </div>
                <p>Vehicle Details</p>

            </div>
            <div class="line {{ $currentStep >= 2 ? 'filled' : '' }}"></div>
            <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                </div>
                <p>Personal Details</p>
            </div>
            @if(false)
            <div class="line {{ $currentStep == 3 ? 'filled' : '' }}"></div>
            <div class="step {{ $currentStep == 3 ? 'active' : '' }}">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.5 3a.5.5 0 0 1 .416.223L11.75 5H14a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h2.25l.834-1.777A.5.5 0 0 1 5.5 3h5ZM8 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                </div>
                <p>Upload Images</p>
            </div>
            @endif
        </div>
        <form wire:submit.prevent="save" novalidate>
            {{-- STEP 1: Car Details --}}
            @if ($currentStep === 1)
            <div id="step-2">
                <h5 class="p-20 fw-600 mb-4">Vehicle Details</h5>
                <div class="row">
                    <!-- START: Searchable Selects Integration -->
                    <div class="row" x-data="searchableSelects()" x-init="init()">
                        <div class="col-lg-6">
                            <x-searchable-select
                                label="Makes"
                                :options="$brands"
                                placeholder="Search for a make..."
                                wire:model.live="brand_id" />
                            @error('brand_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="d-flex align-items-center">
                                <!-- The component itself -->
                                <div class="flex-grow-1">
                                    <x-searchable-select
                                        label="Model"
                                        :options="$models"
                                        placeholder="Select a make first..."
                                        listen-event="models-updated"
                                        wire:model="make_id" />
                                </div>
                                <!-- Loading spinner remains here, controlled by the parent -->
                                <div wire:loading wire:target="brand_id" class="ms-2" style="margin-top: 20px;">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            @error('make_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="modelYear" class="form-label">Model Year</label>

                            <select class="form-select" wire:model.defer="year">
                                <option value="">Select Year</option>
                                @for ($i = date('Y'); $i >= 1980; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('year')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>




                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Mileage (in km)</label>
                            <select name="mileage" class="form-control" wire:model="mileage">
                                @foreach(\App\Enums\MileageRange::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('mileage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Specification</label>
                            <input type="text" wire:model.lazy="specification" class="form-control" placeholder="e.g., GCC, German, japanese">
                            @error('specification') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Common Question</label>
                            <select wire:model.lazy="faq" class="form-select">
                                <option value="">Select a Question</option>
                                <option value="How do I sell my car?">How do I sell my car?</option>
                                <option value="How long does it take?">How long does it take?</option>
                                <option value="Do you offer Trade-In?">Do you offer Trade-In?</option>
                                <option value="How is my car valued?">How is my car valued?</option>
                            </select>
                            @error('faq') <div class="text-danger small mt-1">{{ $message }}
                </div> @enderror
            </div>
    </div>--}}
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label class="form-label">Additional Notes</label>
            <textarea wire:model.lazy="notes" class="form-control" rows="1" placeholder="Any additional notes..."></textarea>
            @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
</div>
@endif
{{-- STEP 2: Personal Info --}}
@if ($currentStep === 2)
<div id="step-1">
    <h5 class="p-20 fw-600 mb-4">Personal Details</h5>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" wire:model.lazy="name" class="form-control" placeholder="Enter your full name">
                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="col-lg-6">
            <div x-data="dubaiPhoneMask()" class="form-group mb-3">
                <label for="phone" class="mt-1 form-label">Phone Number</label>
                <input type="tel" id="phone" class="form-control" placeholder="+971 5xxxxxxxx"
                    x-model="phone" @input="formatPhone" wire:model="phone">
                @error('phone')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" wire:model.lazy="email" class="form-control" placeholder="Enter your Email">
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>
@endif


@if(false)
{{-- STEP 3: Images --}}
@if ($currentStep === 3)
<div id="step-3">
    <h5 class="p-20 fw-600 mb-4">Upload Images</h5>
    <div class="col-lg-12">
        {{-- This is our new, clean, reusable component --}}
        <x-multi-image-uploader wire:model="images" />

        {{-- The validation errors still work perfectly --}}
        @error('images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    </div>
</div>
@endif
@endif

<!-- Navigation Buttons -->
<div class="mt-4 d-flex justify-content-between">
    @if ($currentStep > 1)
    <button type="button" class="btn-main gray" wire:click="previousStep">
        <i class="fas fa-arrow-left me-2"></i> Previous
    </button>
    @else
    <div></div> {{-- Empty div to keep "Next" on the right --}}
    @endif

    @if ($currentStep < 2)
        <button type="button" class="btn-main dark" wire:click="nextStep">
        Next <i class="fas fa-arrow-right ms-2"></i>
        </button>
        @endif

        @if ($currentStep === 2)
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