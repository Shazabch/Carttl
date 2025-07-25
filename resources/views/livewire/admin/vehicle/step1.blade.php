<div>
    <h5>Basic Information</h5> <hr>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Vehicle Title</label>
            <input type="text" class="form-control @error('vehicleData.title') is-invalid @enderror" wire:model.defer="vehicleData.title">
            @error('vehicleData.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Brand</label>
            <select class="form-control @error('vehicleData.brand_id') is-invalid @enderror" wire:model.live="vehicleData.brand_id">
                <option value="">Select Brand</option>
                @foreach ($brands as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
            </select>
            @error('vehicleData.brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Model</label>
            <select class="form-control @error('vehicleData.vehicle_model_id') is-invalid @enderror" wire:model.defer="vehicleData.vehicle_model_id">
                <option value="">Select Model</option>
                @foreach ($models as $model) <option value="{{ $model->id }}">{{ $model->name }}</option> @endforeach
            </select>
            @error('vehicleData.vehicle_model_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Year</label>
            <input type="number" class="form-control @error('vehicleData.year') is-invalid @enderror" wire:model.defer="vehicleData.year">
            @error('vehicleData.year') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" step="0.01" class="form-control @error('vehicleData.price') is-invalid @enderror" wire:model.defer="vehicleData.price">
            @error('vehicleData.price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>