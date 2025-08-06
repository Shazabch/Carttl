<div>
    <h5>Basic Information</h5>
    <hr>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Vehicle Title</label>
            <input type="text" class="form-control @error('vehicleData.title') is-invalid @enderror" wire:model.defer="vehicleData.title">
            @error('vehicleData.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Brand</label>
            <x-select3
                id="select-brand-vehicle"
                dataArray="brands"
                wire:model.live="vehicleData.brand_id"
                placeholder="Select one"
                :allowAdd="true" />
            @error('vehicleData.brand_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror

        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Model</label>
            <x-select3
                id="select-vmodels-vehicle"
                dataArray="models"
                wire:model="vehicleData.vehicle_model_id"
                placeholder="Select one"
                :allowAdd="true" />
            @error('vehicleData.vehicle_model_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror

        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Year</label>
            <select class="form-control @error('vehicleData.year') is-invalid @enderror" wire:model.defer="vehicleData.year">
                <option value="">Select Year</option>
                @for ($year = date('Y'); $year >= 1900; $year--)
                    <option value="{{ $year }}" {{ (isset($vehicleData['year']) && $vehicleData['year'] == $year) ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
            @error('vehicleData.year') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Price (AED)</label>
            <input type="number" step="0.01" class="form-control @error('vehicleData.price') is-invalid @enderror" wire:model.defer="vehicleData.price">
            @error('vehicleData.price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Engine Type</label>
            <input type="text" class="form-control @error('vehicleData.engine_type') is-invalid @enderror" wire:model.defer="vehicleData.engine_type">
            @error('vehicleData.engine_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Top Speed</label>
            <input type="number" step="0.01" class="form-control @error('vehicleData.top_speed') is-invalid @enderror" wire:model.defer="vehicleData.top_speed">
            @error('vehicleData.top_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-4">
            <label class="form-label">Mileage</label>
            <input type="number" class="form-control @error('vehicleData.mileage') is-invalid @enderror" wire:model.defer="vehicleData.mileage">
            @error('vehicleData.mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-4">
            <label class="form-label">Engine (CC)</label>
            <input type="number" class="form-control" wire:model.defer="vehicleData.engine_cc">
            @error('vehicleData.engine_cc')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @error('vehicleData.engine_cc') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        <div class="col-md-4 mb-4">
            <label class="form-label">Horsepower</label><input type="number" class="form-control" wire:model.defer="vehicleData.horsepower">
        </div>
        @error('vehicleData.horsepower') <div class="text-danger small mt-2">{{ $message }}</div> @enderror



    </div>
</div>