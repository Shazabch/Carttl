<div class="">
    <label class="form-item-label">{{ $label }}</label>
    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
        @foreach($options as $value => $optionLabel)
            @php
                $selected = ($vehicleData[$property] ?? null) == $value;
                $class = $selected ? 'active-primary' : 'btn-light';
            @endphp
            <button type="button"
                    wire:click="setSingleSelection('{{ $property }}', '{{ $value }}')"
                    class="btn {{ $class }}">


                {{ $optionLabel }}

            </button>
        @endforeach
    </div>
</div>