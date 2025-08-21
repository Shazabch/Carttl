<div class="form-section">
    <div class="form-section-header">
        <h5>Engine & Transmission</h5>
    </div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'Engine Oil',
                'property' => 'engineOil',
                'options' => ['No Leak', 'Minor Leak', 'Major Leak'],
                'optionClasses' => [
                    'No Leak' => 'active-green',
                    'Minor Leak' => 'active-warning',
                    'Major Leak' => 'active-red',
                ],
            ])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'Gear Oil',
                'property' => 'gearOil',
                'options' => ['No Leak', 'Minor Leak', 'Major Leak'],
                'optionClasses' => [
                    'No Leak' => 'active-green',
                    'Minor Leak' => 'active-warning',
                    'Major Leak' => 'active-red',
                ],
            ])</div>

            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'Gear Shifting',
                'property' => 'gearshifting',
                'options' => ['No Visible Fault', 'Judder', 'Hard', 'Noisy'],
                'optionClasses' => [
                    'No Visible Fault' => 'active-green',
                    'Judder' => 'active-warning',
                    'Hard' => 'active-red',
                ],
            ])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'Engine noise',
                'property' => 'engineNoise',
                'options' => ['Tappet Noise', 'Abnormal Noise', 'Cranking Noise', 'No visible Fault'],
                'optionClasses' => [
                    'No visible Fault' => 'active-green',
                    'Cranking Noise' => 'active-warning',
                    'Abnormal Noise' => 'active-primary',
                    'Tappet Noise' => 'active-red',
                ],
            ])</div>

            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'Engine smoke',
                'property' => 'engineSmoke',
                'options' => ['No smoke', 'White', 'Black'],
            ])</div>
            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => '4 WD system Condition',
                'property' => 'fourWdSystemCondition',
                'options' => ['No Visible fault', 'Stuck', 'N/A', 'Not Engaging'],
                'optionClasses' => [
                    'No Visible fault' => 'active-green',
                    'Stuck' => 'active-warning',
                    'N/A' => 'active-primary',
                    'Not Engaging' => 'active-red',
                ],
            ])</div>

            <div class="col-md-6">@include('livewire.admin.inspection.sections.partials.toggle-single', [
                'label' => 'OBD Error',
                'property' => 'obdError',
                'options' => ['No Error', 'Minor Error', 'Major Error'],
            ])</div>

            <div class="col-md-12">
                @include('livewire.admin.inspection.sections.partials.input-text', [
                    'label' => 'Remarks',
                    'property' => 'remarks',
                ])
            </div>
        </div>
    </div>
</div>
