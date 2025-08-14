<div>
    <div>
        <div class="form-widget-head">
            <div class="banner-text">
                <h5 class=" fw-500 text-white mb-1">Sell Used Cars at Best Price</h5>
                <ul class="theme_list white">
                    <li>Free car inspection</li>
                    <li>Instant payment</li>
                </ul>
            </div>
            <img src="{{ asset('images/sellcar.png') }}">
        </div>

        <div class="form-widget-wrapper">
            @if ($formSubmitted)
            <div class="card shadow-lg border-0 rounded-lg text-center p-2 p-md-5">
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
            {{-- Global error summary shown on all steps --}}
            @if ($errors->any())
            <div class="error-container mt-1 mb-1 p-1"
                style="background-color: #fff5f5;
                        border-left: 4px solid #f56565;
                        border-radius: 4px;
                        max-width: 600px;
                        margin: 20px auto 0;">

                <div class="text-left">
                    @foreach ($errors->all() as $error)
                    <div class="d-flex align-items-start mb-2">
                        <i class="fas fa-times-circle text-danger mt-1 mx-2" style="font-size: 0.8rem;"></i>
                        <span class="text-danger">{{ $error }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Current selection summary (steps 2–6) --}}
            @php
            $selectedBrand = null;
            if (!empty($formData['brand_id'])) {
            $selectedBrand = optional(collect($brands)->firstWhere('id', $formData['brand_id']))
            ?: optional(collect($featuredBrands)->firstWhere('id', $formData['brand_id']));
            }
            $selectedModel = !empty($formData['make_id'])
            ? optional(collect($models)->firstWhere('id', $formData['make_id']))
            : null;
            @endphp

            @if(false)
            @if ($step >= 2)
            <div class="card mb-3 p-2 px-3 small text-muted">
                <div class="d-flex flex-wrap gap-3">
                    <div>
                        <strong>Make:</strong>
                        <span>{{ $selectedBrand ? $selectedBrand->name : '—' }}</span>
                    </div>
                    <div>
                        <strong>Model:</strong>
                        <span>{{ $selectedModel ? $selectedModel->name : '—' }}</span>
                    </div>
                    <div>
                        <strong>Year:</strong>
                        <span>{{ $formData['year'] ?: '—' }}</span>
                    </div>
                    <div>
                        <strong>Mileage:</strong>
                        <span>
                            @php
                            $mOpts = \App\Enums\MileageRange::options();
                            echo isset($formData['mileage'], $mOpts[$formData['mileage']]) ? $mOpts[$formData['mileage']] : '—';
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
            @endif
            @endif

            {{-- Step 1: Select Featured Brand --}}
            @if ($step === 1)
            <div class="step-section active">
                <h6 class="p-16 fw-500 mb-3">Select your car Make to sell</h6>
                <div class="brand-grid">
                    @foreach ($featuredBrands as $brand)
                    @php $isSelected = (string)($formData['brand_id'] ?? '') === (string)$brand->id; @endphp
                    <div class="brand-card {{ $isSelected ? 'selected' : '' }}"
                        wire:click="selectBrand({{ $brand->id }})"
                        role="button" aria-pressed="{{ $isSelected ? 'true' : 'false' }}">
                        <img src="{{ $brand->image_source ?? asset('images/icons/BMW.svg') }}">
                        <h5 class="d-flex align-items-center gap-2 mb-0">
                            {{ $brand->name }}
                            @if($isSelected)
                            <i class="fa-solid fa-check text-success"></i>
                            @endif
                        </h5>
                    </div>
                    @endforeach
                </div>
                @error('formData.brand_id') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
            </div>
            @endif

            {{-- Step 2: Select Any Brand (with Search) --}}
            @if ($step === 2)
            <div class="step-section active">
                <div class="row d-flex">
                    <div class="col-6"></div>
                    <button class="back-btn col-3" wire:click="back">
                        <i class="fa-solid fa-chevron-left"></i> Back
                    </button>
                    <button class="next-btn btn-primary text-light col-3" wire:click="next">
                        Next <i class="fa-solid fa-chevron-right text-light"></i>
                    </button>
                </div>

                <h6>Select your car Make</h6>
                <input type="text" class="form-control search-box" wire:model.live="brandSearch" placeholder="Search for your car’s make">
                <ul class="brand-list">
                    @forelse ($brands as $brand)
                    @php $isSelected = (string)($formData['brand_id'] ?? '') === (string)$brand->id; @endphp
                    <li class="{{ $isSelected ? 'selected' : '' }}"
                        wire:click="selectBrand({{ $brand->id }})"
                        role="button" aria-selected="{{ $isSelected ? 'true' : 'false' }}">
                        <span>{{ $brand->name }}</span>
                        @if($isSelected)
                        <i class="fa-solid fa-check text-success ms-2"></i>
                        @endif
                    </li>
                    @empty
                    <li>No Make found.</li>
                    @endforelse
                </ul>
                @error('formData.brand_id') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
            </div>
            @endif

            {{-- Step 3: Select Model --}}
            @if ($step === 3)
            <div class="step-section active">
                <div class="row d-flex">
                    <div class="col-6"></div>
                    <button class="back-btn col-3" wire:click="back">
                        <i class="fa-solid fa-chevron-left"></i> Back
                    </button>
                    <button class="next-btn btn-primary text-light col-3" wire:click="next">
                        Next <i class="fa-solid fa-chevron-right text-light"></i>
                    </button>
                </div>

                <h6>Select your car model</h6>
                <ul class="brand-list">
                    @forelse ($models as $model)
                    @php $isSelected = (string)($formData['make_id'] ?? '') === (string)$model->id; @endphp
                    <li class="{{ $isSelected ? 'selected' : '' }}"
                        wire:click="selectModel({{ $model->id }})"
                        role="button" aria-selected="{{ $isSelected ? 'true' : 'false' }}">
                        <span>{{ $model->name }}</span>
                        @if($isSelected)
                        <i class="fa-solid fa-check text-success ms-2"></i>
                        @endif
                    </li>
                    @empty
                    <li>No models found for this Make.</li>
                    @endforelse
                </ul>
                @error('formData.make_id') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
            </div>
            @endif

            {{-- Step 4: Select Year --}}
            @if ($step === 4)
            <div class="step-section active">
                <div class="row d-flex">
                    <div class="col-6"></div>
                    <button class="back-btn col-3" wire:click="back">
                        <i class="fa-solid fa-chevron-left"></i> Back
                    </button>
                    <button class="next-btn btn-primary text-light col-3" wire:click="next">
                        Next <i class="fa-solid fa-chevron-right text-light"></i>
                    </button>
                </div>

                <h6>Select your car year</h6>
                <ul class="brand-list" id="yearList">
                    @foreach ($years as $year)
                    @php $isSelected = (string)($formData['year'] ?? '') === (string)$year; @endphp
                    <li class="{{ $isSelected ? 'selected' : '' }}"
                        wire:click="selectYear({{ $year }})"
                        role="button" aria-selected="{{ $isSelected ? 'true' : 'false' }}">
                        <span>{{ $year }}</span>
                        @if($isSelected)
                        <i class="fa-solid fa-check text-success ms-2"></i>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @error('formData.year') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror
            </div>
            @endif

            {{-- Step 5: Vehicle Details --}}
            @if ($step === 5)
            <div class="step-section active">
                <div class="row d-flex">
                    <div class="col-6"></div>
                    <button class="back-btn col-3" wire:click="back">
                        <i class="fa-solid fa-chevron-left"></i> Back
                    </button>
                    <button class="next-btn btn-primary text-light col-3" wire:click="next">
                        Next <i class="fa-solid fa-chevron-right text-light"></i>
                    </button>
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
                </div>
                 <div class="row d-flex">
                    <div class="col-6"></div>
                    <button class="back-btn col-3" wire:click="back">
                        <i class="fa-solid fa-chevron-left"></i> Back
                    </button>
                    <button class="next-btn btn-primary text-light col-3" wire:click="next">
                        Next <i class="fa-solid fa-chevron-right text-light"></i>
                    </button>
                </div>
            </div>
            @endif

            {{-- Step 6: Personal Details & Submit --}}
            @if ($step === 6)
            <div class="step-section active">
                <button class="back-btn" wire:click="back">
                    <i class="fa-solid fa-chevron-left"></i> Back
                </button>

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

    <style>
        /* Minimal visual cue for selected items; adjust to match your design system */
        .brand-list li.selected,
        .brand-card.selected {
            border: 1px solid #198754;
            /* Bootstrap success */
            background: rgba(25, 135, 84, 0.08);
        }

        .brand-list li {
            cursor: pointer;
        }

        .brand-card {
            cursor: pointer;
        }
    </style>
</div>