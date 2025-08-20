<div class="form-section">
    <div class="form-section-header">
        <h5>Basic Vehicle Information</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-item">
                    <label class="form-label">Make</label>
                    <select id="vehicle-brand-select" wire:model.live="reportData.make" class="form-control @error('reportData.make') is-invalid @enderror">
                        <option value="">Select Make</option>
                        @foreach($brands as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                    @error('reportData.make') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-item">
                    <label class="form-label">Model</label>
                    <select id="vehicle-model-select" wire:model.live="reportData.model" class="form-control @error('reportData.model') is-invalid @enderror">
                        <option value="">Select model</option>
                        @foreach($models as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                    @error('reportData.model') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-item">
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
            </div>

            <div class="col-md-4">
                <div class="form-item">
                    <label class="form-label">Mileage / Odometer(kms)</label>
                    <input type="number" step="10" class="form-control @error('reportData.odometer') is-invalid @enderror" wire:model.defer="reportData.odometer">

                    @error('reportData.odometer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
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
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Transmission', 'property' => 'transmission','options' => ['Automatic', 'Manual']])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Warranty', 'property' => 'warrantyAvailable', 'options' => ['Yes', 'No']])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Service Contract', 'property' => 'serviceContractAvailable', 'options' => ['Yes', 'No']])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Service History', 'property' => 'serviceHistory', 'options' => ['FDSH', 'FSH','Partial','No']])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'No Of Keys', 'property' => 'noOfKeys', 'options' => ['1', '2','3','4','5']])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Mortgage', 'property' => 'mortgage', 'options' => ['Yes', 'No']])
            </div>
    
        </div>
    </div>
</div>