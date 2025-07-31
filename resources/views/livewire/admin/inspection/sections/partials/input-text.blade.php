<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>
    <input type="text" class="form-control" placeholder="Tap to edit" wire:model.lazy="report.{{ $property }}">
</div>