<div class="form-section">
    <div class="form-section-header">
        <h5>Basic Vehicle Information</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            {{-- We use the 'input-text' partial for most of these --}}
            <div class="col-md-4">

                <div class="form-item">
                    <label class="form-item-label">Make</label>
                    <x-select3
                        id="select-brand-vehicle"
                        dataArray="brands"
                        wire:model.live="reportData.make"
                        placeholder="Select one"
                        :allowAdd="true" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-item">
                    <label class="form-item-label">Model</label>
                    <x-select3
                        id="select-model-vehicle"
                        dataArray="models"
                        wire:model.live="reportData.model"
                        placeholder="Select one"
                        :allowAdd="true" />
                </div>
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Year', 'property' => 'year'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Mileage / Odometer', 'property' => 'odometer'])
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