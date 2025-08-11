<div>


    <div class="row">
        <div class="col-12 mb-2">
            <fieldset>
                <legend class="form-label">Details & Publishing</legend>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Torque</label>
                        <input type="text" class="form-control @error('vehicleData.torque') is-invalid @enderror" wire:model.defer="vehicleData.torque">
                        @error('vehicleData.torque') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Seats</label>
                        <select name="seats" class="form-control @error('vehicleData.seats') is-invalid @enderror" wire:model.defer="vehicleData.seats">
                            @foreach(range(1, 8) as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('vehicleData.seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Doors</label>
                        <select name="doors" class="form-control @error('vehicleData.doors') is-invalid @enderror" wire:model.defer="vehicleData.doors">
                            @foreach(range(1, 8) as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('vehicleData.doors') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Color</label>
                        <select name="color" class="form-control @error('vehicleData.color') is-invalid @enderror" wire:model.defer="vehicleData.color">
                            <option value="">Select Color</option>
                            @foreach(\App\Enums\VehicleColor::cases() as $color)
                            <option value="{{ $color->value }}">{{ $color->label() }}</option>
                            @endforeach
                        </select>
                        @error('vehicleData.color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Interior Color</label>
                        <select name="interior_color" class="form-control @error('vehicleData.interior_color') is-invalid @enderror" wire:model.defer="vehicleData.interior_color">
                            <option value="">Select Interior Color</option>
                            @foreach(\App\Enums\VehicleColor::cases() as $color)
                            <option value="{{ $color->value }}">{{ $color->label() }}</option>
                            @endforeach
                        </select>
                        @error('vehicleData.interior_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-12">
            <fieldset>
                <legend class="form-label">Condition & Status</legend>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label d-block">Condition</label>
                        <div class="row g-2">
                            @foreach (['new', 'used', 'certified'] as $condition)
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="option-card {{ ($vehicleData['condition'] ?? 'used') == $condition ? 'selected' : '' }}">
                                    <input type="checkbox" class="d-none" wire:click="setSingleSelection('condition', '{{ $condition }}')">
                                    <span class="option-name text-capitalize">{{ $condition }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('vehicleData.condition') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label d-block">Listing Status</label>
                        <div class="row g-2">
                            @foreach (['draft', 'published', 'sold', 'pending'] as $status)
                            <div class="col-sm-3 col-6 col-md-2">
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
            </fieldset>
        </div>
    </div>
    {{-- Description --}}
    <fieldset class="mb-4">
        <legend class="form-label">Description</legend>
        <textarea class="form-control" rows="4" wire:model.defer="vehicleData.description"></textarea>
        @error('vehicleData.description')
        <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </fieldset>

    {{-- Switches --}}
    <fieldset>
        <legend class="form-label">Options</legend>

        <div class="row">
            @if($vehicleData['is_auction'])
            {{-- Starting Bid Amount --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Starting Bid Amount (AED)</label>
                <input type="number" step="0.01" class="form-control @error('vehicleData.starting_bid_amount') is-invalid @enderror"
                    wire:model.defer="vehicleData.starting_bid_amount">
                @error('vehicleData.starting_bid_amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Auction End Date</label>
                <input type="datetime-local" class="form-control @error('vehicleData.auction_end_date') is-invalid @enderror"
                    wire:model.defer="vehicleData.auction_end_date">
                @error('vehicleData.auction_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endif

            {{-- 0-60 mph --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">0-60 mph (seconds)</label>
                <input type="number" step="0.01" class="form-control @error('vehicleData.zero_to_sixty') is-invalid @enderror"
                    wire:model.defer="vehicleData.zero_to_sixty">
                @error('vehicleData.zero_to_sixty')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Quarter Mile --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Quarter Mile Time (seconds)</label>
                <input type="number" step="0.01" class="form-control @error('vehicleData.quater_mile') is-invalid @enderror"
                    wire:model.defer="vehicleData.quater_mile">
                @error('vehicleData.quater_mile')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            {{-- Is Hot --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">&nbsp;</label> <!-- Placeholder for vertical alignment -->
                <div class="form-check form-switch p-3 border rounded">
                    <label class="form-check-label fw-bold" for="is_hot">@if($vehicleData['is_auction']) Hot Bid @else Hot Listing @endif</label>
                    @include('livewire.admin.vehicle.partials.toggle-single', ['label' => '', 'property' => 'is_hot', 'options' => [ 0 => 'No',1 => 'Yes']])
                    @error('vehicleData.is_hot')
                    <div class="text-danger small w-100 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Inspected By --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">&nbsp;</label> <!-- Placeholder for vertical alignment -->
                <div class="form-check form-switch p-3 border rounded">

                    <label class="form-check-label fw-bold" for="inspected_by">Inspected By</label>
                    @include('livewire.admin.vehicle.partials.toggle-single', ['label' => '', 'property' => 'inspected_by', 'options' => [ 0 => 'No',1 => 'Yes']])
                    @error('vehicleData.inspected_by')
                    <div class="text-danger small w-100 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Price is Negotiable --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">&nbsp;</label> <!-- Placeholder for vertical alignment -->
                <div class="form-check form-switch p-3 border rounded">

                    <label class="form-check-label fw-bold" for="negotiable">Price is Negotiable</label>
                    @include('livewire.admin.vehicle.partials.toggle-single', ['label' => '', 'property' => 'negotiable', 'options' => [ 0 => 'No',1 => 'Yes']])
                    @error('vehicleData.negotiable')
                    <div class="text-danger small w-100 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if(!$vehicleData['is_auction'])
            {{-- Feature this Vehicle --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">&nbsp;</label> <!-- Placeholder for vertical alignment -->
                <div class="form-check form-switch p-3 border rounded">

                    <label class="form-check-label fw-bold" for="is_featured">Do You want to list this on homepage?</label>
                    @include('livewire.admin.vehicle.partials.toggle-single', ['label' => '', 'property' => 'is_featured', 'options' => [ 0 => 'No',1 => 'Yes']])
                </div>
            </div>
            @endif


        </div>
    </fieldset>
</div>