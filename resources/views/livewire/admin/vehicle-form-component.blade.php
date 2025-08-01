<div>
    @if($showForm)
    <div class="card shadow-sm" style="background-color: #f8f9fa;">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            {{-- Wizard Progress Bar --}}
            <div class="wizard-progress">
                {{-- This blue line grows based on the current step --}}
                <div class="progress-bar-line" style="width: {{ ($currentStep - 1) * 50 }}%;"></div>

                {{-- Step 1 --}}
                <div class="wizard-step @if($currentStep == 1) active @elseif($currentStep > 1) completed @endif">
                    <div class="step-icon">
                        @if($currentStep > 1) <i class="fas fa-check"></i> @else 1 @endif
                    </div>
                    <div class="step-label">Basic & General</div>
                </div>

                {{-- Step 2 --}}
                <div class="wizard-step @if($currentStep == 2) active @elseif($currentStep > 2) completed @endif">
                    <div class="step-icon">
                        @if($currentStep > 2) <i class="fas fa-check"></i> @else 2 @endif
                    </div>
                    <div class="step-label">Exterior & Specs</div>
                </div>

                {{-- Step 3 --}}
                <div class="wizard-step @if($currentStep == 3) active @endif">
                    <div class="step-icon">3</div>
                    <div class="step-label">Condition Details</div>
                </div>
            </div>
            <hr class="mt-4 mb-0">
        </div>
        <div class="card-body py-4">
            {{-- The content for each step is loaded here --}}
            <div>
                @if ($currentStep == 1)
                    {{-- The h5 title is now part of the step include --}}
                    @include('livewire.admin.vehicle.step1')
                @elseif ($currentStep == 2)
                    @include('livewire.admin.vehicle.step2')
                @elseif ($currentStep == 3)
                    @include('livewire.admin.vehicle.step3')
                @endif
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                @if ($currentStep > 1)
                    <button class="btn btn-light border" wire:click="prevStep">Back</button>
                @endif
            </div>
            <div>
                <button class="btn btn-danger" wire:click="cancel">Cancel</button>

                @if ($currentStep < 3)
                    <button class="btn btn-primary" wire:click="nextStep">Next</button>
                @else
                    {{-- On the last step, the button becomes "Save Vehicle" --}}
                    <button class="btn btn-primary" wire:click="saveVehicle">Save Vehicle</button>
                @endif

                {{-- Your existing logic for showing Save button during editing --}}
                @if($isEditing && $currentStep < 3)
                    <button class="btn btn-success" wire:click="saveVehicle">Save Vehicle</button>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Add this CSS to your main stylesheet or keep it in this @push block --}}
@push('styles')
<style>
    /*
    |--------------------------------------------------------------------------
    | Wizard Stepper Styles (Matches the screenshot)
    |--------------------------------------------------------------------------
    */
    .wizard-progress {
        position: relative;
        display: flex;
        justify-content: space-between;
        width: 80%;
        margin: 0 auto;
    }

    /* The gray line underneath */
    .wizard-progress::before {
        content: '';
        position: absolute;
        top: 19px; /* Vertically center with the icon */
        left: 0;
        width: 100%;
        height: 4px;
        background-color: #e0e0e0;
        z-index: 1;
    }

    /* The blue progress line that grows */
    .progress-bar-line {
        position: absolute;
        top: 19px; /* Match the gray line */
        left: 0;
        height: 4px;
        background-color: #0d6efd; /* Bootstrap Primary Blue */
        z-index: 2;
        transition: width 0.4s ease;
    }

    .wizard-step {
        position: relative;
        z-index: 3;
        text-align: center;
        color: #adb5bd; /* Default gray color for text */
    }

    .step-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #adb5bd; /* Default gray border */
        margin: 0 auto 10px auto;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.4s ease;
    }

    .step-label {
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* --- Step States --- */

    /* Active Step */
    .wizard-step.active .step-icon {
        border-color: #0d6efd;
        color: #0d6efd;
    }
    .wizard-step.active .step-label {
        color: #0d6efd;
        font-weight: bold;
    }

    /* Completed Step */
    .wizard-step.completed .step-icon {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }
    .wizard-step.completed .step-label {
        color: #212529; /* Standard text color */
    }


    /*
    |--------------------------------------------------------------------------
    | Form Field Styles (Kept from previous version)
    |--------------------------------------------------------------------------
    */
    .option-card {
        display: block;
        padding: 0.75rem 1rem;
        border: 1px solid gray;
        border-radius: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        position: relative;
        background-color: white;
    }
    .option-card:hover {
        border-color: blue;
    }
    .option-card.selected {
        border-color: gray;
        background-color: gray;
        color: white;
        font-weight: 500;
        box-shadow: 0 0 0 2px var(--bs-primary-border-subtle);
    }
    /* You can use a checkmark icon or a simple border highlight */
    .option-card.selected::after {
        content: '';
        position: absolute;
        top: -2px; right: -2px; bottom: -2px; left: -2px;
        border: 2px solid var(--bs-primary);
        border-radius: inherit;
    }
</style>
@endpush