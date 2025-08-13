<div>

    <div class="form-widget-head">
        <div class="banner-text">
            <h5 class="p-16 fw-500 text-white mb-3">Sell Used Cars at Best Price</h5>
            <ul class="theme_list white">
                <li>Free car inspection</li>
                <li>Instant payment</li>
            </ul>
        </div>
        <img src="{{asset('images/sellcar.png')}}">
    </div>
    <div class="form-widget-wrapper">
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
                <a href="/" class="btn btn-outline-secondary mt-2" wire:navigate>
                    <i class="fas fa-plus-circle me-2"></i> Submit Another Enquiry
                </a>
            </div>
        </div>
        @else
        <!-- Step 1: Select Featured Brand -->
        @if ($step === 1)
        <div class="step-section active">
            <h6 class="p-16 fw-500 mb-3">Select your car Make to sell</h6>
            <div class="brand-grid">
                @foreach ($featuredBrands as $brand)
                <div class="brand-card" wire:click="selectBrand({{ $brand->id }})">
                    <img src="{{ $brand->image_source ?? asset('images/icons/BMW.svg') }}">
                    <h5>{{ $brand->name }}</h5>
                </div>
                @endforeach
            </div>
            <!-- <button class="theme_btn w-100 justify-content-center py-3 mt-3" wire:click="goToStep(5)">GET BEST PRICE (Skip)</button> -->
        </div>
        @endif

        <!-- Step 2: Select Any Brand (with Search) -->
        @if ($step === 2)
        <div class="step-section active">
            <div class="row d-flex ">
                 <div class="col-6"></div>
                 <button class="back-btn col-3" wire:click="goToStep(1)"><i class="fa-solid fa-chevron-left"></i> Back</button>
                 <button class="next-btn btn-primary text-light  col-3" wire:click="goToStep(3)">Next <i class="fa-solid fa-chevron-right text-light"></i> </button>

            </div>

            <h6>Select your car Make</h6>
            <input type="text" class="form-control search-box" wire:model.live="brandSearch" placeholder="Search for your car’s make">
            <ul class="brand-list">
                @forelse ($brands as $brand)
                <li wire:click="selectBrand({{ $brand->id }})">{{ $brand->name }}</li>
                @empty
                <li>No Make found.</li>
                @endforelse
            </ul>
        </div>
        @endif

        <!-- Step 3: Select Model -->
        @if ($step === 3)
        <div class="step-section active">
             <div class="row d-flex ">
                 <div class="col-6"></div>
                 <button class="back-btn col-3" wire:click="goToStep(2)"><i class="fa-solid fa-chevron-left"></i> Back</button>
                 <button class="next-btn btn-primary text-light col-3" wire:click="goToStep(4)">Next<i class="fa-solid fa-chevron-right text-light"></i></button>

            </div>
            <h6>Select your car model</h6>
            <ul class="brand-list">
                @forelse ($models as $model)
                <li wire:click="selectModel({{ $model->id }})">{{ $model->name }}</li>
                @empty
                <li>No models found for this Make.</li>
                @endforelse
            </ul>
        </div>
        @endif

        <!-- Step 4: Select Year -->
        @if ($step === 4)
        <div class="step-section active">
             <div class="row d-flex ">
                 <div class="col-6"></div>
                 <button class="back-btn col-3" wire:click="goToStep(3)"><i class="fa-solid fa-chevron-left"></i> Back</button>
                 <button class="next-btn btn-primary text-light col-3" wire:click="goToStep(5)">Next <i class="fa-solid fa-chevron-right text-light"></i></button>

            </div>
            <h6>Select your car year</h6>
            <ul class="brand-list" id="yearList">
                @foreach ($years as $year)
                <li wire:click="selectYear({{ $year }})">{{ $year }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Step 5: Vehicle Details -->
        @if ($step === 5)
        <div class="step-section active">
             <div class="row d-flex ">
                 <div class="col-6"></div>
                 <button class="back-btn col-3" wire:click="goToStep(4)"><i class="fa-solid fa-chevron-left"></i> Back</button>
                 <button class="next-btn btn-primary text-light col-3" wire:click="goToStep(6)"> Next <i class="fa-solid fa-chevron-right text-light"></i></button>

            </div>
            <h6>Fill This Information</h6>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-3">

                        <label class="form-label">Mileage (in km)</label>
                        <select name="mileage" class="form-control" wire:model.lazy="formData.mileage">
                            @foreach(\App\Enums\MileageRange::options() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        @error('formData.mileage') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Specification</label>
                        <input type="text" class="form-control" wire:model.lazy="formData.specification" placeholder="e.g., GCC, German, Japanese">
                        @error('formData.specification') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-4">
                        <label class="form-label">Additional Notes</label>
                        <textarea class="form-control" rows="1" wire:model.lazy="formData.notes" placeholder="Any additional notes..."></textarea>
                        @error('formData.notes') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <button class="btn-main w-100 justify-content-center" wire:click="goToStep(6)">Next</button>
                </div>
            </div>
        </div>
        @endif

        <!-- Step 6: Personal Details & Submit -->
        @if ($step === 6)
        <div class="step-section active">
            <button class="back-btn" wire:click="goToStep(5)"><i class="fa-solid fa-chevron-left"></i> Back</button>

            <h6>Personal Details</h6>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-1">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" wire:model.lazy="formData.name" placeholder="Enter your full name">
                        @error('formData.name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-1">
                        <label class="form-label">Contact Number</label>
                        <div x-data="dubaiPhoneMask()" class="form-group mb-1">

                            <input type="tel" id="phone" class="form-control" placeholder="+971 5xxxxxxxx"
                                x-model="phone" @input="formatPhone" wire:model.live="formData.phone">

                            @error('formData.phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-1">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" wire:model.lazy="formData.email" placeholder="Enter your Email">
                            @error('formData.email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn-main w-100 justify-content-center" wire:click="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">Submit</span>
                            <span wire:loading wire:target="submit">Submitting...</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>