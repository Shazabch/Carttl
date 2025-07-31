<div class="form-section">
    <div class="form-section-header"><h5>Tires</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Front left side', 'property' => 'frontLeftTire', 'options' => ['No visible fault', 'Worn', 'Damaged']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Front right side', 'property' => 'frontRightTire', 'options' => ['No visible fault', 'Worn', 'Damaged']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Rear left Side', 'property' => 'rearLeftTire', 'options' => ['No visible fault', 'Worn', 'Damaged']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Rear right side', 'property' => 'rearRightTire', 'options' => ['No visible fault', 'Worn', 'Damaged']])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Tires size', 'property' => 'tiresSize'])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Spare tire', 'property' => 'spareTire', 'options' => ['Available', 'Not Available']])
            </div>
        </div>
    </div>
</div>