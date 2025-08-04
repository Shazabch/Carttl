<div>
    <h5>Specifications</h5> <hr>
    <div class="row">
        <div class="col-md-4 mb-4"><label class="form-label">Mileage</label><input type="number" class="form-control @error('vehicleData.mileage') is-invalid @enderror" wire:model.defer="vehicleData.mileage">
        @error('vehicleData.mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-4 mb-4"><label class="form-label">Engine (CC)</label><input type="number" class="form-control" wire:model.defer="vehicleData.engine_cc"></div>
         @error('vehicleData.engine_cc') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        <div class="col-md-4 mb-4"><label class="form-label">Horsepower</label><input type="number" class="form-control" wire:model.defer="vehicleData.horsepower"></div>
         @error('vehicleData.horsepower') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 mb-4">
        <label class="form-label d-block">Transmission</label>
        <div class="row g-2">
            @foreach ($transmissions as $item)
                <div class="col-6 col-sm-4 col-md-3">
                    <label class="option-card  {{ ($vehicleData['transmission_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('transmission_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.transmission_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 mb-4">
        <label class="form-label d-block">Fuel Type</label>
        <div class="row g-2">
            @foreach ($fuelTypes as $item)
                <div class="col-6 col-sm-4 col-md-3">
                    <label class="option-card {{ ($vehicleData['fuel_type_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('fuel_type_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.fuel_type_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 mb-4">
        <label class="form-label d-block">Body Type</label>
        <div class="row g-2">
            @foreach ($bodyTypes as $item)
                <div class="col-6 col-sm-4 col-md-3">
                    <label class="option-card {{ ($vehicleData['body_type_id'] ?? null) == $item->id ? 'selected' : '' }}">
                        <input type="checkbox" class="d-none" wire:click="setSingleSelection('body_type_id', {{ $item->id }})">
                        <span class="option-name">{{ $item->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('vehicleData.body_type_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    </div>
</div>