<div class="card">
    <div class="card-header">
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

            {{-- Step 3: Specs & Interior --}}
            <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <p>Specs & Interior</p>
            </div>

            <div class="line {{ $currentStep == 4 ? 'filled' : '' }}"></div>

            {{-- Step 4: Damage Assessment --}}
            <div class="step {{ $currentStep == 4 ? 'active' : '' }}">
                <div class="icon">
                    <i class="fas fa-car"></i>
                </div>
                <p>Damage Assessment</p>
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
            @if($currentStep === 4)
            @livewire('car-damage-assessment', ['inspectionId' => $inspectionId], key('damage-assessment-for-inspection-' . $inspectionId))
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