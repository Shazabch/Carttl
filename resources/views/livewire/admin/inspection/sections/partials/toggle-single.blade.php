<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>
    <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
        @foreach($options as $option)
        <button type="button" wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')"
            class="btn w-100
                @if(($reportData[$property] ?? null) == $option)
                    {{ in_array($option, ['Yes', 'Available', 'Safe', 'No visible fault', 'No Error', 'No smoke', '360 degree']) ? 'active-green' : 'active-red' }}
                @else
                    btn-light
                @endif
            ">
            {{ $option }}
        </button>
        @endforeach
    </div>
</div>