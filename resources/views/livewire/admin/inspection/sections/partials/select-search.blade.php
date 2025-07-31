<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>
     <x-select3
                id="select-brand-report-{{ $keyCode }}"
                dataArray="{{ $dataArray }}"
                wire:model.live="report.{{ $property }}"
                placeholder="Select one"
                :allowAdd="true" />

</div>