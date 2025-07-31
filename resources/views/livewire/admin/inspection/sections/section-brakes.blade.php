<div class="form-section">
    <div class="form-section-header"><h5>Steering, suspension & Brakes</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Steering operation', 'property' => 'steeringOperation', 'options' => ['No Visible fault', 'Noisy', 'Hard', 'Spongy']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Wheel Alignment', 'property' => 'wheelAlignment', 'options' => ['No visible fault', 'Alignment out']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Brake pads', 'property' => 'brakePads', 'options' => ['No visible Fault', 'Worn out']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Suspension', 'property' => 'suspension', 'options' => ['No visible fault', 'Arms-Bushes Crack']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Brake Discs', 'property' => 'brakeDiscs', 'options' => ['No visible fault', 'Front Noisy', 'Rear Noisy', 'Rusty']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Shock Absorber Operation', 'property' => 'shockAbsorberOperation', 'options' => ['No Visible fault', 'Noisy', 'Hard', 'Spongy']])</div>
        </div>
    </div>
</div>