<div>
    <h5>Details & Publishing</h5> <hr>
    <div class="row">
        <div class="col-md-6 mb-4"><label class="form-label">VIN</label><input type="text" class="form-control" wire:model.defer="vehicleData.vin"></div>
        <div class="col-md-6 mb-4"><label class="form-label">Registration No.</label><input type="text" class="form-control" wire:model.defer="vehicleData.registration_no"></div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label class="form-label d-block">Condition</label>
            <div class="row g-2">
                @foreach (['new', 'used', 'certified'] as $condition)
                    <div class="col-4">
                        <label class="option-card {{ ($vehicleData['condition'] ?? 'used') == $condition ? 'selected' : '' }}">
                            <input type="checkbox" class="d-none" wire:click="setSingleSelection('condition', '{{ $condition }}')">
                            <span class="option-name text-capitalize">{{ $condition }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            @error('vehicleData.condition') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-4">
            <label class="form-label d-block">Status</label>
            <div class="row g-2">
                @foreach (['draft', 'published', 'sold', 'pending'] as $status)
                    <div class="col-sm-3 col-6">
                        <label class="option-card {{ ($vehicleData['status'] ?? 'draft') == $status ? 'selected' : '' }}">
                            <input type="checkbox" class="d-none" wire:click="setSingleSelection('status', '{{ $status }}')">
                            <span class="option-name text-capitalize">{{ $status }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            @error('vehicleData.status') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="4" wire:model.defer="vehicleData.description"></textarea>
            @error('vehicleData.description') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check form-switch p-3 border rounded">
                <input class="form-check-input" type="checkbox" role="switch" id="negotiable" wire:model.defer="vehicleData.negotiable">
                <label class="form-check-label" for="negotiable"><span class="fw-bold">Price is Negotiable</span></label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-switch p-3 border rounded">
                <input class="form-check-input" type="checkbox" role="switch" id="is_featured" wire:model.defer="vehicleData.is_featured">
                <label class="form-check-label" for="is_featured"><span class="fw-bold">Feature this Vehicle</span></label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check form-switch p-3 border rounded">
                <input class="form-check-input" type="checkbox" role="switch" id="is_auction" wire:model.defer="vehicleData.is_auction">
                <label class="form-check-label" for="is_auction"><span class="fw-bold">Is Auction</span></label>
            </div>
        </div>
    </div>
</div>