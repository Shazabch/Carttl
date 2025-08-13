<div class="form-section">
    <div class="form-section-header">
        <h5>Interior, Electrical & Air Conditioner</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Speedmeter cluster', 'property' => 'speedmeterCluster', 'options' => ['No Visible fault', 'Warning light on', 'Not working', 'Replaced'],'optionClasses' => [
                'No Visible fault' => 'active-green',
                'Warning light on' => 'active-warning',
                'Not working' => 'active-primary',
                'Replaced' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Head Lining', 'property' => 'headLining', 'options' => ['No Visible fault', 'Dirty', 'Damaged'],'optionClasses' => [
                'No Visible fault' => 'active-green',
                'Dirty' => 'active-warning',
                'Damaged' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Seat Controls', 'property' => 'seatControls', 'options' => ['No visible fault', 'Not working'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Not working' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Seats Condition', 'property' => 'seatsCondition', 'options' => ['No visible fault', 'Dirty', 'Damaged'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Dirty' => 'active-warning',
                'Damaged' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Central lock operation', 'property' => 'centralLockOperation', 'options' => ['No visible fault', 'Not working'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'Not Working' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Sunroof Condition', 'property' => 'sunroofCondition', 'options' => ['No visible fault', 'STUCK', 'Noisy', 'N/A'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'STUCK' => 'active-warning',
                'N/A' => 'active-primary',
                'Noisy' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Windows Control', 'property' => 'windowsControl', 'options' => ['No visible fault', 'STUCK', 'Noisy', 'N/A'],'optionClasses' => [
                'No visible fault' => 'active-green',
                'STUCK' => 'active-warning',
                'N/A' => 'active-primary',
                'Noisy' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Cruise Control', 'property' => 'cruiseControl', 'options' => ['No visible fault', 'Not working', 'N/A'],'optionClasses' => [
                'No visible fault' => 'active-green',

                'N/A' => 'active-warning',
                'Not working' => 'active-red',
                ]])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'A/C Cooling', 'property' => 'acCooling', 'options' => ['No visible fault', 'NOT COOLING', 'Comppreser NOT Working'],'optionClasses' => [
                'No Visible fault' => 'active-green',
                'NOT COOLING' => 'active-warning',
                'Comppreser NOT Working' => 'active-red',
                ]])</div>
            <div class="col-md-12">
                @include('livewire.admin.inspection.sections.partials.input-text', ['label' => 'Comments', 'property' => 'comment_section2'])
            </div>
        </div>
    </div>
</div>