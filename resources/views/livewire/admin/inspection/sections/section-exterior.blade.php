<div class="form-section">
    <div class="form-section-header"><h5>Exterior</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.multi-select', ['label' => 'Paint Condition', 'property' => 'paintCondition', 'options' => ['Original paint', 'Red:Repainted', 'Green:cosmetic paint', 'Gray:scratch', 'Blue:Dent', 'Foiled wrap', 'FULL PPF', 'Brown : Rust']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Convertible', 'property' => 'convertible', 'options' => ['Soft Top', 'Hard Top', 'Not Available']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Blind Spot', 'property' => 'blindSpot', 'options' => ['Available', 'Not Available']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Side steps', 'property' => 'sideSteps', 'options' => ['Available', 'Not Available']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Wheels Type', 'property' => 'wheelsType'])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Rims size (Front)', 'property' => 'rimsSizeFront'])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Rims size (Rear)', 'property' => 'rimsSizeRear'])
            </div>
        </div>
    </div>
</div>