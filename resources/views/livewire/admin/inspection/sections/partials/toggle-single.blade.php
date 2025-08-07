<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>
    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
        @foreach($options as $option)
            @php
                $selected = ($reportData[$property] ?? null) === $option;
                $class = $selected
                    ? ($optionClasses[$option] ?? 'active-primary')  // fallback if no class provided
                    : 'btn-light';
            @endphp
            <button type="button"
                    wire:click="setSingleSelection('{{ $property }}', '{{ $option }}')"
                    class="btn {{ $class }}">
                {{ $option }}
            </button>
        @endforeach
    </div>
</div>
