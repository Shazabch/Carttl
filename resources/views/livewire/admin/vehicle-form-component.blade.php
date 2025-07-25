<div>
    @if($showForm)
    <div class="card">
        <div class="card-header bg-light border-0 pt-4 pb-0">
            {{-- Wizard Progress Bar --}}
            <div class="wizard-progress">
                <div class="progress-bar-line" style="width: {{ ($currentStep - 1) * 50 }}%;"></div>
                <div class="wizard-step @if($currentStep == 1) active @elseif($currentStep > 1) completed @endif">
                    <div class="step-icon">@if($currentStep > 1) <i class="fas fa-check"></i> @else 1 @endif</div>
                    <div class="step-label">Basic Info</div>
                </div>
                <div class="wizard-step @if($currentStep == 2) active @elseif($currentStep > 2) completed @endif">
                    <div class="step-icon">@if($currentStep > 2) <i class="fas fa-check"></i> @else 2 @endif</div>
                    <div class="step-label">Specifications</div>
                </div>
                <div class="wizard-step @if($currentStep == 3) active @endif">
                    <div class="step-icon">3</div>
                    <div class="step-label">Details</div>
                </div>
            </div>
            <hr class="mt-4">
        </div>
        <div class="card-body">
            @if ($currentStep == 1)
            @include('livewire.admin.vehicle.step1')
            @elseif ($currentStep == 2)
            @include('livewire.admin.vehicle.step2')
            @elseif ($currentStep == 3)
            @include('livewire.admin.vehicle.step3')
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div>
                @if ($currentStep > 1)
                <button class="btn btn-secondary" wire:click="prevStep">Back</button>
                @endif
            </div>
            <div>
                <button class="btn btn-danger" wire:click="cancel">Cancel</button>
                @if ($currentStep < 3)
                    <button class="btn btn-primary" wire:click="nextStep">Next</button>
                    @if($isEditing)
                    <button class="btn btn-success" wire:click="saveVehicle">Save Vehicle</button>
                    @endif
                    @else
                    <button class="btn btn-success" wire:click="nextStep">Save Vehicle</button>
                    @endif
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Add this CSS to your main stylesheet (e.g., public/css/app.css) --}}
@push('styles')
<style>
    .wizard-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .progress-bar-line {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 4px;
        background-color: #0d6efd;
        z-index: 1;
        transition: width 0.3s ease-in-out;
    }

    .wizard-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 2;
        width: 33.33%;
    }

    .wizard-step .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #495057;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .wizard-step .step-label {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .wizard-step.active .step-icon {
        border-color: #0d6efd;
        background-color: #fff;
        color: #0d6efd;
    }

    .wizard-step.active .step-label {
        color: #0d6efd;
        font-weight: 600;
    }

    .wizard-step.completed .step-icon {
        border-color: #0d6efd;
        background-color: #0d6efd;
        color: #fff;
    }

    .wizard-step.completed .step-label {
        color: #212529;
    }

    .option-card {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        height: 100%;
    }

    .option-card:hover {
        border-color: #0d6efd;
    }

    .option-card.selected {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        color: #0d6efd;
    }

    .option-card .option-name {
        font-weight: 600;
    }

    .option-card input[type="checkbox"] {
        display: none;
    }
</style>
@endpush