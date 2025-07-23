<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Users</h4>
            <div class="col-md-4">
                {{-- Use wire:model.live.debounce for real-time search --}}
                <input type="text" class="form-control" placeholder="Search by name or email"
                    wire:model.live.debounce.500ms="search">
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" wire:click="addNew">
                Add User
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user?->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <i class="fas fa-edit text-info me-2" style="cursor: pointer;"
                                    wire:click="editItem({{ $user->id }})" title="Edit"></i>

                                <i class="fas fa-trash text-danger" style="cursor: pointer;"
                                    wire:click="$dispatch('confirmDeleteUser', { id: {{ $user->id }} })"
                                    title="Delete"></i>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- CHANGE 3: REMOVE wire:ignore.self from the modal --}}
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            {{-- Change wire:submit.prevent to wire:submit --}}
            <form wire:submit="saveUser" class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title  text-white">{{ $user_id ? 'Edit' : 'Add' }} User </h5>

                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name <small class="text-danger">*</small></label>
                        {{-- Use wire:model instead of wire:model.defer for instant feedback --}}
                        <input type="text" class="form-control" wire:model="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Email <small class="text-danger">*</small></label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Password <small class="text-danger">*</small></label>
                        <input type="password" class="form-control" wire:model="password" autocomplete="new-password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Role <small class="text-danger">*</small></label>
                        <select class="form-control" wire:model="role">
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <div wire:loading wire:target="saveUser" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        {{ $user_id ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('confirmDeleteUser', (event) => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This user will be deleted permanently.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteItem', {
                                id: event.id
                            });
                        }
                    });
                });

                // Event listener for success notifications
                Livewire.on('success-notification', (event) => {
                    Swal.fire({
                        title: 'Success!',
                        text: event.message,
                        icon: 'success',
                    });
                });

                window.addEventListener('open-modal', event => {
                    $('#userModal').modal('show');
                });
                Livewire.on('close-modal', () => {
                    const userModal = document.getElementById('userModal');
                    const modal = bootstrap.Modal.getInstance(userModal);
                    if (modal) {
                        modal.hide();
                    }
                });
            });
        </script>
    @endpush
</div>
