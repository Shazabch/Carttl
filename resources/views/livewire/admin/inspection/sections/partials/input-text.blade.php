@props([
'label',
'property',
'type' => 'text',
'placeholder' => ''
])
<div class="form-item">
    <div class="mb-3">
        <label for="{{ $property }}" class="form-label">{{ $label }}</label>
        <input
            type="{{ $type }}"
            class="form-control @error('reportData.' . $property) is-invalid @enderror"
            id="{{ $property }}"
            placeholder="{{ $placeholder ?: $label }}"
            {{-- THIS IS THE MOST IMPORTANT LINE --}}
            wire:model="reportData.{{ $property }}">
        @error('reportData.' . $property)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>