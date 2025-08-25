<div>

    <div class="row">
        <fieldset class="col-12 mb-4">
            <legend class="form-label">Vehicle Type</legend>

            <div class="col-md-4 mb-3">
                <label class="form-label">&nbsp;</label>
                @include('livewire.admin.vehicle.partials.toggle-single', ['label' => '', 'property' => 'is_auction', 'options' => [ 0 => 'Vehicle',1 => 'Auction']])
            </div>
        </fieldset>
        <fieldset class="col-12 mb-4">
            <legend class="form-label">General Details</legend>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Vehicle Title</label>
                    <input type="text" class="form-control @error('vehicleData.title') is-invalid @enderror" wire:model.defer="vehicleData.title">
                    @error('vehicleData.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Make</label>
                    <select id="vehicle-brand-select" wire:model.live="vehicleData.brand_id" class="form-control">
                        <option value="">Select Make</option>
                        @foreach($brands as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                    @error('vehicleData.brand_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Model</label>
                    <select id="vehicle-model-select" wire:model.live="vehicleData.vehicle_model_id" class="form-control">
                        <option value="">Select model</option>
                        @foreach($models as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                    @error('vehicleData.vehicle_model_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Trim</label>
                    <input type="text" class="form-control @error('vehicleData.trim') is-invalid @enderror" wire:model.defer="vehicleData.trim">
                    @error('vehicleData.trim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Year</label>
                    <select class="form-control @error('vehicleData.year') is-invalid @enderror" wire:model.defer="vehicleData.year">
                        <option value="">Select Year</option>
                        @for ($year = date('Y'); $year >= 1900; $year--)
                        <option value="{{ $year }}" {{ (isset($vehicleData['year']) && $vehicleData['year'] == $year) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endfor
                    </select>
                    @error('vehicleData.year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </fieldset>

        {{-- Performance --}}
        <fieldset class="col-12 mb-4">
            <legend class="form-label">Performance</legend>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Engine</label>
                    <select name="engine_displacement" class="form-control" wire:model.defer="vehicleData.engine_type">
                        @foreach(\App\Enums\EngineDisplacement::options() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('vehicleData.engine_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Top Speed</label>
                    <input type="number" step="0.01" class="form-control @error('vehicleData.top_speed') is-invalid @enderror" wire:model.defer="vehicleData.top_speed">
                    @error('vehicleData.top_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Mileage(kms)</label>
                    <input type="number" step="10" class="form-control @error('vehicleData.mileage') is-invalid @enderror" wire:model.defer="vehicleData.mileage">

                    @error('vehicleData.mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Engine (CC)</label>
                    <input type="number" class="form-control" wire:model.defer="vehicleData.engine_cc">
                    @error('vehicleData.engine_cc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Horsepower</label>
                    <input type="number" class="form-control" wire:model="vehicleData.horsepower">
                    @error('vehicleData.horsepower') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">No Of Cylinders</label>
                    <input type="number" class="form-control" wire:model="vehicleData.no_of_cylinder">
                    @error('vehicleData.no_of_cylinder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Remarks</label>
                    
                    <textarea  class="form-control" wire:model="vehicleData.remarks"></textarea>
                    @error('vehicleData.remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </fieldset>

        {{-- Pricing --}}
        <fieldset class="col-12 mb-4">
            <legend class="form-label">Pricing</legend>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Price (AED)</label>
                    <input type="number" step="0.01" class="form-control @error('vehicleData.price') is-invalid @enderror" wire:model.defer="vehicleData.price">
                    @error('vehicleData.price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
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
            </div>
        </fieldset>

        {{-- Identification --}}
        <fieldset class="col-12 mb-4">
            <legend class="form-label">Identification</legend>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Vehicle Identification No.</label>
                    <input type="text" class="form-control" wire:model.defer="vehicleData.vin">
                    @error('vehicleData.vin') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Reference No.</label>
                    <input type="text" class="form-control" wire:model.defer="vehicleData.registration_no">
                    @error('vehicleData.registration_no') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
            </div>
        </fieldset>

    </div>
</div>