<div>
    @if($showForm)
    <div class="card">
        <div class="card-header bg-light border-0 pt-4 pb-0">
            {{-- Wizard Progress Bar --}}
            <div class="wizard-progress">
                <div class="progress-bar-line" style="width: {{ ($currentStep - 1) * 50 }}%;"></div>
                <div class="wizard-step @if($currentStep == 1) active @elseif($currentStep > 1) completed @endif">
                    <div class="step-icon">@if($currentStep > 1) <i class="fas fa-check"></i> @else 1 @endif</div>
                    <div class="step-label">Basic & General</div>
                </div>
                <div class="wizard-step @if($currentStep == 2) active @elseif($currentStep > 2) completed @endif">
                    <div class="step-icon">@if($currentStep > 2) <i class="fas fa-check"></i> @else 2 @endif</div>
                    <div class="step-label">Exterior & Specs</div>
                </div>
                <div class="wizard-step @if($currentStep == 3) active @endif">
                    <div class="step-icon">3</div>
                    <div class="step-label">Condition Details</div>
                </div>
            </div>
            <hr class="mt-4">
        </div>
        <div class="card-body" style="background-color: #f8f9fa;">
            <div class="space-y-4">
                @if ($currentStep == 1)
                    @include('livewire.admin.vehicle.step1')
                @elseif ($currentStep == 2)
                    @include('livewire.admin.vehicle.step2')
                @elseif ($currentStep == 3)
                    @include('livewire.admin.vehicle.step3')
                @endif
            </div>
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

{{-- Add this CSS to your main stylesheet or keep it here --}}
@push('styles')
<style>
    /* Wizard Progress Bar Styles (from your old code, they work great) */
    .wizard-progress { display: flex; justify-content: space-between; position: relative; }
    .progress-bar-line { position: absolute; top: 50%; left: 0; transform: translateY(-50%); height: 4px; background-color: #0d6efd; z-index: 1; transition: width 0.3s ease-in-out; }
    .wizard-step { display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; z-index: 2; width: 33.33%; }
    .wizard-step .step-icon { width: 40px; height: 40px; border-radius: 50%; background-color: #e9ecef; color: #495057; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid #e9ecef; transition: all 0.3s ease; }
    .wizard-step .step-label { margin-top: 0.5rem; font-size: 0.9rem; color: #6c757d; }
    .wizard-step.active .step-icon { border-color: #0d6efd; background-color: #fff; color: #0d6efd; }
    .wizard-step.active .step-label { color: #0d6efd; font-weight: 600; }
    .wizard-step.completed .step-icon { border-color: #0d6efd; background-color: #0d6efd; color: #fff; }
    .wizard-step.completed .step-label { color: #212529; }

    /* NEW STYLES for form elements */
    .form-section { background: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .form-section-header { background-color: #6f42c1; color: white; padding: 1rem; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
    .form-section-header h5 { margin-bottom: 0; font-size: 1.1rem; }
    .form-section-body { padding: 1rem; border: 1px solid #dee2e6; border-top: 0; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
    .form-item { background-color: #f8f9fa; border: 1px solid #e9ecef; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem; }
    .form-item:last-child { margin-bottom: 0; }
    .form-item-label { font-weight: 600; color: #495057; margin-bottom: 0.5rem; display: block; }
    .btn-group-toggle .btn { border: 1px solid #ced4da; }
    .btn-group-toggle .btn.active-green { background-color: #198754; color: white; border-color: #198754; }
    .btn-group-toggle .btn.active-red { background-color: #dc3545; color: white; border-color: #dc3545; }
    .select-response-btn { background-color: #6f42c1; color: white; width: 100%; }
    .tag { display: inline-flex; align-items: center; padding: 0.25em 0.75em; font-size: 85%; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.375rem; margin-right: 0.5rem; margin-bottom: 0.5rem; }
    .tag-red { background-color: #dc3545; }
    .tag-green { background-color: #198754; }
    .tag-gray { background-color: #6c757d; }
    .tag-blue { background-color: #0d6efd; }
    .tag-purple { background-color: #6f42c1; }
    .modal-backdrop { position: fixed; top: 0; left: 0; z-index: 1040; width: 100vw; height: 100vh; background-color: #000; opacity: .5; }
    .modal.show { display: block; }
</style>
@endpush