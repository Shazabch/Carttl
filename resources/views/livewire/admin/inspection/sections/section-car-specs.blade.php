<div class="form-section">
    <div class="form-section-header"><h5>Car Specs</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Parking Sensors', 'property' => 'parkingSensors', 'options' => ['Front', 'Front & Rear', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Keyless Start', 'property' => 'keylessStart', 'options' => ['Available', 'Not Available']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Seats', 'property' => 'seats', 'options' => ['Leather', 'Fabric', 'Alcantara']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Cooled Seats', 'property' => 'cooledSeats', 'options' => ['Available', 'Not Available']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Heated Seats', 'property' => 'heatedSeats', 'options' => ['Available', 'Not Available']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Power Seats', 'property' => 'powerSeats', 'options' => ['Available', 'Not Available']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Vive Camera', 'property' => 'viveCamera', 'options' => ['Rear', 'Front &Rear', '360 degree']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Sunroof Type', 'property' => 'sunroofType', 'options' => ['Panoramic', 'Dual', 'Normal', 'N/A', 'Moonroof']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Drive', 'property' => 'drive', 'options' => ['FWD', 'RWD', 'AWD', '4WD']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Blind Spots', 'property' => 'blindSpot', 'options' => ['Available', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Heads Up Display', 'property' => 'headsDisplay', 'options' => ['Available', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Premium Sound System', 'property' => 'premiumSound', 'options' => ['Available', 'N/A']])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', ['label' => 'Carbon Fiber Interior', 'property' => 'carbonFiber', 'options' => ['Available', 'N/A']])</div>

        </div>
    </div>
</div>