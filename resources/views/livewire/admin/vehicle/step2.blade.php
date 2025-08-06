<div>


    {{-- Transmission --}}
    <fieldset class="mb-4">
        <legend class="form-label">Transmission</legend>
        <div class="row g-2">
            @foreach ($transmissions as $item)
                <div class="col-6 col-sm-4 col-md-2">
                    <label class="option-card {{ ($vehicleData['transmission_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('transmission_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.transmission_id')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </fieldset>

    {{-- Fuel Type --}}
    <fieldset class="mb-4">
        <legend class="form-label">Fuel Type</legend>
        <div class="row g-2">
            @foreach ($fuelTypes as $item)
                <div class="col-6 col-sm-4 col-md-2">
                    <label class="option-card {{ ($vehicleData['fuel_type_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('fuel_type_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.fuel_type_id')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </fieldset>

    {{-- Body Type --}}
    <fieldset class="mb-4">
        <legend class="form-label">Body Type</legend>
        <div class="row g-2">
            @foreach ($bodyTypes as $item)
                <div class="col-6 col-sm-4 col-md-2">
                    <label class="option-card {{ ($vehicleData['body_type_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('body_type_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.body_type_id')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </fieldset>

    {{-- Vehicle Tags --}}
    <fieldset class="mb-4">
        <legend class="form-label">Vehicle Tags</legend>
        <div class="row g-2">
            @foreach ($tags as $tag)
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="option-card {{ in_array($tag->id, $selectedFeatures) ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:model.live="selectedFeatures" value="{{ $tag->id }}">
                        <span class="option-name">{{ $tag->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </fieldset>

    {{-- Exterior Features --}}
    <fieldset class="mb-4">
        <legend class="form-label">Exterior Features</legend>
        <div class="row g-2">
            @foreach ($exteriorFeatures as $feature)
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="option-card {{ in_array($feature->id, $selectedFeatures) ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:model.live="selectedFeatures" value="{{ $feature->id }}">
                        <span class="option-name">{{ $feature->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </fieldset>

    {{-- Interior Features --}}
    <fieldset>
        <legend class="form-label">Interior Features</legend>
        <div class="row g-2">
            @foreach ($interiorFeatures as $feature)
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="option-card {{ in_array($feature->id, $selectedFeatures) ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:model.live="selectedFeatures" value="{{ $feature->id }}">
                        <span class="option-name">{{ $feature->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </fieldset>

</div>
