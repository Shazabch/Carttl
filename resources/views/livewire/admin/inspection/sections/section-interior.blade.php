<div class="form-section">
    <div class="form-section-header"><h5>Interior, Electrical & Air Conditioner</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Speedmeter cluster', 'property' => 'speedmeterCluster', 'options' => ['No Visible fault', 'Warning light on', 'Not working', 'Replaced']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Head Lining', 'property' => 'headLining', 'options' => ['No Visible fault', 'Dirty', 'Damaged']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Seat Controls', 'property' => 'seatControls', 'options' => ['No visible fault', 'Not working']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.modal-select', ['label' => 'Seats Condition', 'property' => 'seatsCondition', 'options' => ['No visible fault', 'Dirty', 'Damaged']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Central lock operation', 'property' => 'centralLockOperation', 'options' => ['No visible fault', 'Not working']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Sunroof Condition', 'property' => 'sunroofCondition', 'options' => ['No visible fault', 'STUCK', 'Noisy', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Windows Control', 'property' => 'windowsControl', 'options' => ['No visible fault', 'STUCK', 'Noisy', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Cruise Control', 'property' => 'cruiseControl', 'options' => ['No visible fault', 'Not working', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'A/C Cooling', 'property' => 'acCooling', 'options' => ['No visible fault', 'NOT COOLING', 'Comppreser NOT Working']])</div>
        </div>
    </div>
</div>