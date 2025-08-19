<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Manage Status for: {{ $vehicle->title }}</h5>
    </div>
    <div class="card-body">
        <div class="col-12">
            <fieldset>
                <legend class="form-label">Condition & Status</legend>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label d-block">Condition</label>
                        <div class="row g-2">
                            @foreach (['new', 'used', 'certified by gx'] as $condition)
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
                            @foreach (['draft', 'published', 'sold', 'pending','upcoming'] as $status)
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

            <fieldset>
                <legend class="form-label">Options</legend>
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

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" wire:click="saveVehicle">Save Vehicle</button>
                </div>

            </fieldset>
        </div>
    </div>
</div>