<div>
    @if ($showForm)
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $isEditing ? 'Edit Make' : 'Add New Make' }}</h5>
            <button class="btn btn-sm btn-light" wire:click="cancel">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="card-body py-4">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="name" class="form-label">Make Name</label>
                    <input type="text" id="name" class="form-control" wire:model.defer="name"
                        placeholder="Enter make name">
                    @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Repeater for models --}}
                <div class="mb-3">
                    <label class="form-label">Models</label>
                    <div class="row g-2">
                        @foreach ($models as $index => $model)
                        <div class="col-md-4 mt-1 d-flex align-items-center">
                            <input type="text" class="form-control" wire:model.defer="models.{{ $index }}"
                                placeholder="Model name">

                            <button type="button" class="btn btn-sm btn-danger ms-2 ml-1"
                                wire:click="removeModelField({{ $index }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" wire:click="addModelField">
                        <i class="fas fa-plus"></i> Add Model
                    </button>

                    @error('models.*')
                    <span class="text-danger small d-block">{{ $message }}</span>
                    @enderror
                </div>

            </form>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2 py-3">
            <button type="button" class="btn btn-light border" wire:click="cancel">Cancel</button>
            <button type="button" class="btn btn-primary" wire:click="save">
                {{ $isEditing ? 'Update Make & Models' : 'Save Make & Models' }}
            </button>
        </div>
    </div>
    @endif
</div>