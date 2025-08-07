<div class="form-section">
    <div class="form-section-header">
        <h5>Tires</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Front left side', 'property' => 'frontLeftTire', 'options' => ['No visible fault', 'Worn', 'Damaged'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Worn' => 'active-warning',
                'Damaged' => 'active-red',
                ]])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Front right side', 'property' => 'frontRightTire', 'options' => ['No visible fault', 'Worn', 'Damaged',],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Worn' => 'active-warning',
                'Damaged' => 'active-red',
                ]])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Rear left Side', 'property' => 'rearLeftTire', 'options' => ['No visible fault', 'Worn', 'Damaged'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Worn' => 'active-warning',
                'Damaged' => 'active-red',
                ]])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Rear right side', 'property' => 'rearRightTire', 'options' => ['No visible fault', 'Worn', 'Damaged'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Worn' => 'active-warning',
                'Damaged' => 'active-red',
                ]])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Tires size', 'property' => 'tiresSize'])
            </div>
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Spare tire', 'property' => 'spareTire', 'options' => ['Available', 'Not Available'],'optionClasses' => [
                'Available' => 'active-green',
                'Not Available' => 'active-red',
                ]])
            </div>
        </div>
    </div>
</div>