<div>

    @if($showForm)
    <div class="card shadow-sm">
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
            <div>
                @if ($currentStep == 1)
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

                    <button class="btn btn-primary" wire:click="nextStep">Save Vehicle</button>
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

