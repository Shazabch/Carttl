<div>
    @php
    $user = auth()->guard('admin')->user();
    // Checks if the authenticated user has either 'super-admin' or 'admin' role.
    $isPrivilegedUser = $user && ($user->hasRole('super-admin'));
    @endphp


    @if ($showForm)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $isEditing ? 'Edit Role' : 'Add New Role' }}</h4>
            <button class="btn btn-secondary" wire:click="cancel">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveRole">
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.defer="name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Assign Permissions</label>
                    @error('selectedPermissions') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                    @foreach ($allPermissions as $group => $permissions)

                    <div class="mb-3 border rounded p-3" id="permission-group-{{ $loop->index }}" wire:key="group-{{ $group }}">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <h6 class="text-capitalize mb-0">{{ $group }}</h6>
                            <div>

                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    wire:click="selectAllPermissionsInGroup({{ json_encode($permissions->pluck('name')->toArray()) }})"
                                    onclick="toggleAllPermissionsInGroup(this, true)">
                                    Select All
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-secondary ms-1"
                                    wire:click="deselectAllPermissionsInGroup({{ json_encode($permissions->pluck('name')->toArray()) }})"
                                    onclick="toggleAllPermissionsInGroup(this, false)">
                                    Deselect All
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($permissions as $permission)
                            <div class="col-md-4" wire:key="permission-{{ $permission['id'] }}">
                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" value="{{ $permission['name'] }}"
                                        wire:model.live="selectedPermissions"
                                        id="perm-{{ $permission['id'] }}">
                                    <label class="form-check-label" for="perm-{{ $permission['id'] }}">
                                        {{ $permission['name'] }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" wire:click="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isEditing ? 'Update Role' : 'Save Role' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @else

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Roles</h4>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by name..." wire:model.live.debounce.500ms="search">
            </div>
            @if ($isPrivilegedUser || $user->can('role-manage'))
            <button class="btn btn-primary" wire:click="addNew">
                <i class="fas fa-plus-circle me-1"></i> Add Role
            </button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $index => $item)
                        <tr wire:key="role-{{ $item->id }}">
                            <td>{{ $roles->firstItem() + $index }}</td>
                            <td>{{ $item?->name }}</td>
                            <td>
                                @foreach ($item->permissions->take(4) as $permission)
                                <span class="badge bg-secondary mb-1">{{ $permission->name }}</span>
                                @endforeach
                                @if ($item->permissions->count() > 4)
                                <span class="badge bg-primary text-white mb-1">+{{ $item->permissions->count() - 4 }} more</span>
                                @endif
                            </td>
                            <td>
                                @if ($isPrivilegedUser || $user->can('role-manage'))
                                <i class="fas fa-edit text-info me-2" style="cursor: pointer;" wire:click="editItem({{ $item->id }})" title="Edit"></i>
                                @if ($item?->name != 'super-admin' && $item?->name != 'admin' && $item?->name != 'inspector')
                                <i class="fas fa-trash text-danger"
                                    style="cursor: pointer;"
                                    wire:click="$dispatch('confirmDelete', { id: {{ $item->id }} })"
                                    title="Delete"></i>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No roles found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // We no longer need modal listeners.
        // The SweetAlert for delete confirmation is still good.
        @this.on('confirmDelete', ({
            id
        }) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('deleteItem', {
                        id: id
                    });
                }
            });
        });
    });

    function toggleAllPermissionsInGroup(button, shouldBeChecked) {
        // 1. Find the parent container of the button that holds the permission group.
        const groupContainer = button.closest('.border.rounded.p-3');
        if (!groupContainer) return;

        // 2. Find all checkboxes within that specific container.
        const checkboxes = groupContainer.querySelectorAll('input[type="checkbox"]');

        // 3. Loop through each checkbox.
        checkboxes.forEach(checkbox => {
            // 4. Only change if the state is different, to avoid unnecessary events.
            if (checkbox.checked !== shouldBeChecked) {
                checkbox.checked = shouldBeChecked;

                // 5. CRITICAL STEP: Manually dispatch an 'input' event.
                // This is what tells Livewire's `wire:model` that the value has changed.
                checkbox.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        });
    }
</script>
@endpush