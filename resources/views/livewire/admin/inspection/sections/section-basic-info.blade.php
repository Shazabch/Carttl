<div class="form-section">
    <div class="form-section-header">
        <h5>Basic Vehicle Information</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Make</label>
                <select id="vehicle-brand-select" wire:model.live="reportData.make" class="form-control @error('reportData.make') is-invalid @enderror">
                    <option value="">Select brand</option>
                    @foreach($brands as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('reportData.make') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Model</label>
                <select id="vehicle-model-select" wire:model.live="reportData.model" class="form-control @error('reportData.model') is-invalid @enderror">
                    <option value="">Select model</option>
                    @foreach($models as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('reportData.model') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Year</label>
                <select class="form-control @error('reportData.year') is-invalid @enderror" wire:model="reportData.year">
                    <option value="">Select Year</option>
                    @for ($year = date('Y'); $year >= 1900; $year--)
                    <option value="{{ $year }}" {{ (isset($vehicleData['year']) && $vehicleData['year'] == $year) ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endfor
                </select>
                @error('reportData.year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Mileage / Odometer</label>
                <select name="mileage" class="form-control @error('reportData.odometer') is-invalid @enderror" wire:model="reportData.odometer">
                    @foreach(\App\Enums\MileageRange::options() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('reportData.odometer')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Engine CC', 'property' => 'engine_cc'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Horsepower', 'property' => 'horsepower'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'No. of Cylinders', 'property' => 'noOfCylinders'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Transmission', 'property' => 'transmission'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Color', 'property' => 'color'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Specs (e.g., GCC, US)', 'property' => 'specs'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Registered Emirate', 'property' => 'registerEmirates'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Body Type', 'property' => 'body_type']) {{-- Use body_type as it's a string, not an ID --}}
            </div>
        </div>
    </div>
</div>