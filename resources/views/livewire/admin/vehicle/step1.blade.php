<div>
    <h5>Basic Information</h5>
    <hr>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Vehicle Title</label>
            <input type="text" class="form-control @error('vehicleData.title') is-invalid @enderror" wire:model.defer="vehicleData.title">
            @error('vehicleData.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Brand</label>
            <x-select3
                id="select-brand-vehicle"
                dataArray="brands"
                wire:model.live="vehicleData.brand_id"
                placeholder="Select one"
                :allowAdd="true" />

        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Model</label>


            <x-select3
                id="select-model-vehicle"
                dataArray="models"
                wire:model="vehicleData.vehicle_model_id"
                placeholder="Select one"
                :allowAdd="true" />

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
         <div class="col-md-6 mb-3">
            <label class="form-label">Engine</label>
            <input type="text"  class="form-control @error('vehicleData.engine_type') is-invalid @enderror" wire:model.defer="vehicleData.engine_type">
            @error('vehicleData.engine_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
         <div class="col-md-6 mb-3">
            <label class="form-label">Top Speed</label>
            <input type="number" step="0.01" class="form-control @error('vehicleData.top_speed') is-invalid @enderror" wire:model.defer="vehicleData.top_speed">
            @error('vehicleData.top_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>