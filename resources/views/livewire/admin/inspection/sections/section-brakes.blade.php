<div class="form-section">
    <div class="form-section-header">
        <h5>Steering, suspension & Brakes</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Steering operation', 'property' => 'steeringOperation', 'options' => ['No Visible fault', 'Noisy', 'Hard', 'Spongy'],'optionClasses' => [
                'No Visible fault' => 'active-green',
                'Noisy' => 'active-warning',
                'Hard' => 'active-warning',
                'Spongy' => 'active-red'
                ]])</div>

            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Wheel Alignment', 'property' => 'wheelAlignment', 'options' => ['No visible fault', 'Alignment out'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Alignment out' => 'active-red'
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Brake pads', 'property' => 'brakePads', 'options' => ['No visible Fault', 'Worn out'],'optionClasses' => [
                'No visible Fault' => 'active-green',
                'Worn Out' => 'active-red'
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Suspension', 'property' => 'suspension', 'options' => ['No visible fault', 'Arms-Bushes Crack'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Arms-Bushes Crack' => 'active-red'
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Brake Discs', 'property' => 'brakeDiscs', 'options' => ['No visible fault', 'Front Noisy', 'Rear Noisy', 'Rusty'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Front Noisy' => 'active-warning',
                'Rear Noisy' => 'active-warning',
                'Rusty' => 'active-red'
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Shock Absorber Operation', 'property' => 'shockAbsorberOperation', 'options' => ['No Visible fault', 'Noisy', 'Hard', 'Spongy'],'optionClasses' => [
                'No Visible fault' => 'active-green',
                'Noisy' => 'active-warning',
                'Hard' => 'active-warning',
                'Spongy' => 'active-red'
                ]])</div>
        </div>
    </div>
</div>