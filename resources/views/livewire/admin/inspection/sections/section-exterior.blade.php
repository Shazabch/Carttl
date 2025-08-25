<div class="form-section">
    <div class="form-section-header"><h5>Exterior</h5></div>
    <div class="form-section-body">
        <div class="row">
            <div class="col-md-6">
                @include('livewire.admin.inspection.sections.partials.multi-select', ['label' => 'Paint Condition', 'property' => 'paintCondition', 'options' => ['Original paint', 'Red:Repainted', 'Green:cosmetic paint', 'Gray:scratch', 'Blue:Dent', 'Foiled wrap', 'FULL PPF', 'Brown : Rust']])
            </div>
        </div>
    </div>
</div>