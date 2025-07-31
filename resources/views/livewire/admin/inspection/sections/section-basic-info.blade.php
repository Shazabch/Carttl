{{-- resources/views/livewire/admin/inspection/sections/section-basic-info.blade.php --}}

<div class="form-section">
    <div class="form-section-header">
        <h5>Basic Vehicle Information</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            {{-- We use the 'input-text' partial for most of these --}}
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Make', 'property' => 'make'])
            </div>
            <div class="col-md-4">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Model', 'property' => 'model']) {{-- Assuming 'trim' is the model --}}
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