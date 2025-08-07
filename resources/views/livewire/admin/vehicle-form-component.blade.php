<div>

    @if($showForm)
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="custom-progress mb-5">
                {{-- Step 1: Basic & General --}}
                <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                    <div class="icon">
                        <i class="fas fa-user-cog"></i> {{-- Replace icon if needed --}}
                    </div>
                    <p>Basic & General</p>
                </div>

                <div class="line {{ $currentStep >= 2 ? 'filled' : '' }}"></div>

                {{-- Step 2: Exterior & Specs --}}
                <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                    <div class="icon">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <p>Exterior & Specs</p>
                </div>

                <div class="line {{ $currentStep >= 3 ? 'filled' : '' }}"></div>

                {{-- Step 3: Condition Details --}}
                <div class="step {{ $currentStep == 3 ? 'active' : '' }}">
                    <div class="icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <p>Condition Details</p>
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