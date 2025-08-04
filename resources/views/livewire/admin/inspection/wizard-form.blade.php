<div class="card">
    <div class="card-header bg-light border-0 pt-4 pb-0">
        {{-- Wizard Progress Bar --}}
        <div class="wizard-progress">
            <div class="progress-bar-line" style="width: {{ ($currentStep - 1) * 50 }}%;"></div>
            <div class="wizard-step @if($currentStep == 1) active @elseif($currentStep > 1) completed @endif">
                <div class="step-icon">@if($currentStep > 1) <i class="fas fa-check"></i> @else 1 @endif</div>
                <div class="step-label">Exterior & Tires</div>
            </div>
            <div class="wizard-step @if($currentStep == 2) active @elseif($currentStep > 2) completed @endif">
                <div class="step-icon">@if($currentStep > 2) <i class="fas fa-check"></i> @else 2 @endif</div>
                <div class="step-label">Specs & Interior</div>
            </div>
            <div class="wizard-step @if($currentStep == 3) active @endif">
                <div class="step-icon">3</div>
                <div class="step-label">Mechanical</div>
            </div>
        </div>
        <hr class="mt-4">
    </div>

    <div class="card-body" style="background-color: #f8f9fa;">
        <div class="space-y-4">

            @if($currentStep === 1)
            @include('livewire.admin.inspection.sections.section-basic-info')
            @include('livewire.admin.inspection.sections.section-exterior')
            @endif
            @if($currentStep === 2)

            @include('livewire.admin.inspection.sections.section-tires')
            @include('livewire.admin.inspection.sections.section-car-specs')
            @endif
            @if($currentStep === 3)
            @include('livewire.admin.inspection.sections.section-interior')
            @include('livewire.admin.inspection.sections.section-engine')
            @include('livewire.admin.inspection.sections.section-brakes')
            @endif
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <div>
            @if ($currentStep > 1)
            <button type="button" class="btn btn-secondary" wire:click="prevStep">Back</button>
            @endif
        </div>
        <div>
            <button type="button" class="btn btn-danger" wire:click="cancel">Cancel</button>
            @if ($currentStep < 3)
                <button type="button" class="btn btn-primary" wire:click="nextStep">Next</button>
                @else
                <button type="button" class="btn btn-success" wire:click="nextStep">Save Report</button>
                @endif
        </div>
    </div>
</div>