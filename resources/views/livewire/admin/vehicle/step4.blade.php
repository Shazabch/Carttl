<div>
    <div class="row">
        <div class="col-12 mb-2">
            <fieldset>
                <legend class="form-label">Images</legend>
                @if($vehicle_id)
                <livewire:admin.vehicle.vehicle-assets-component :vehicleId="$vehicle_id" />
                @endif
            </fieldset>
        </div>
    </div>
</div>