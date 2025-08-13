<div class="card">
    <div class="bg-white border-top d-flex justify-content-between py-3">
        <div>
            @if ($currentStep > 1)
            <button type="button"
                class="btn btn-outline-secondary mx-2"
                wire:click="prevStep">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
            @endif
        </div>
        <div>
            <button type="button"
                class="btn btn-outline-danger mr-2"
                wire:click="cancel">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>
        </div>
    </div>
    <div class="card-header ">


        <div class="custom-progress mb-5">
            {{-- Step 1: Exterior & Tires --}}
            <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-car-side"></i>
                </div>
                <p>Exterior & Tires</p>
            </div>

            <div class="line {{ $currentStep >= 2 ? 'filled' : '' }}"></div>

            {{-- Step 2: Mechanical --}}
            <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <p>Mechanical</p>
            </div>

            <div class="line {{ $currentStep >= 3 ? 'filled' : '' }}"></div>

            {{-- Step 3: Specs --}}
            <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <p>Specs</p>
            </div>

            <div class="line {{ $currentStep == 4 ? 'filled' : '' }}"></div>

            {{-- Step 4: Damage Assessment --}}
            <div class="step {{ $currentStep == 4 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-camera"></i>
                </div>
                <p>Images</p>
            </div>
            <!-- <div class="line {{ $currentStep >= 4 ? 'filled' : '' }}"></div>
            {{-- Step 4: Damage Assessment --}}
            <div class="step {{ $currentStep == 5 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-car"></i>
                </div>
                <p>Damage Assessment</p>
            </div> -->
        </div>

        <hr class="mt-4">
    </div>

    <div class="card-body">
        <div class="space-y-4">
            @if($currentStep === 1)
            @include('livewire.admin.inspection.sections.section-basic-info')
            @include('livewire.admin.inspection.sections.section-exterior')
            @if($inspectionId)
            @livewire('car-damage-assessment', ['inspectionId' => $inspectionId], key('damage-assessment-for-inspection-' . $inspectionId))
            @else
            {{-- This section replaces the placeholder --}}
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <div class="damage-assessment-placeholder p-5 text-center"
                        style="border: 2px dashed rgba(215, 178, 54, 0.3);
                    border-radius: 10px;
                    background-color: rgba(215, 178, 54, 0.05);
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

                        <div class="placeholder-icon mb-3" style="font-size: 2.5rem; color: rgba(215, 178, 54, 0.5);">
                            <i class="fas fa-car-crash"></i>
                        </div>

                        <h4 class="text-dark mb-3" style="font-weight: 600;">Damage Assessment Required</h4>

                        <p class="text-muted mb-4" style="max-width: 600px; margin: 0 auto; line-height: 1.6;">
                            Before accessing the damage assessment tools, please save the vehicle's basic information.
                            This ensures all data is properly linked in our system.
                        </p>

                        <button type="button"
                            class="btn btn-primary px-4 py-2"
                            style="font-weight: 500; letter-spacing: 0.5px;"
                            wire:click="saveReportDraft"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveReportDraft">
                                <i class="fas fa-save mr-2"></i>Save & Enable Damage Assessment
                            </span>
                            <span wire:loading wire:target="saveReportDraft">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Processing...
                            </span>
                        </button>

                        @if ($errors->any())
                        <div class="error-container mt-4 p-3"
                            style="background-color: #fff5f5;
                        border-left: 4px solid #f56565;
                        border-radius: 4px;
                        max-width: 600px;
                        margin: 20px auto 0;">
                            <h6 class="text-danger mb-2" style="font-weight: 600;">
                                <i class="fas fa-exclamation-circle mr-2"></i>Action Required:
                            </h6>
                            <div class="text-left">
                                @foreach ($errors->all() as $error)
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-times-circle text-danger mt-1 mr-2" style="font-size: 0.8rem;"></i>
                                    <span class="text-danger">{{ $error }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if($currentStep === 2)
            @include('livewire.admin.inspection.sections.section-engine')
            @include('livewire.admin.inspection.sections.section-brakes')
            @include('livewire.admin.inspection.sections.section-interior')
            @endif
            @if($currentStep === 3)
            @include('livewire.admin.inspection.sections.section-tires')
            @include('livewire.admin.inspection.sections.section-car-specs')
            @endif
            @if($currentStep === 4)
            @if($inspectionId)

            <livewire:admin.inspection.section-assets-component :inspectionId="$inspectionId" />
            @endif
            @endif
        </div>
    </div>

    <!-- Footer Navigation -->
    <div class="card-footer bg-white border-top d-flex justify-content-between py-3">
        <div>
            @if ($currentStep > 1)
            <button type="button"
                class="btn btn-outline-secondary"
                wire:click="prevStep">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
            @endif
        </div>
        <div>
            <button type="button"
                class="btn btn-outline-danger mr-2"
                wire:click="cancel">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>

            @if ($currentStep < 4)
                <button type="button"
                class="btn btn-primary"
                wire:click="nextStep">
                Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
                @else
                <button type="button"
                    class="btn btn-success"
                    wire:click="nextStep">
                    <i class="fas fa-check-circle mr-2"></i> Complete Inspection
                </button>
                @endif
        </div>
    </div>
</div>