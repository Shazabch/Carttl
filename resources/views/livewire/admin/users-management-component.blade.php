<div>
    <div class="card">


        {{-- TOGGLEABLE FORM --}}
        @if ($showForm)

            <div class="card-body border-bottom">
                <form wire:submit.prevent="saveUser">
                    {{-- Check $editingUserId to determine if we are editing --}}
                    <h5 class="mb-3">{{ $editingUserId ? 'Edit' : 'Add New' }} User</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" wire:model="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Password @if (!$editingUserId)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <input type="password" class="form-control" wire:model="password"
                                autocomplete="new-password"
                                placeholder="{{ $editingUserId ? 'Leave blank to keep current' : '' }}">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Role <span class="text-danger">*</span></label>
                            <select class="form-control" wire:model="role">
                                <option value="">Select ROle</option>
                                @foreach ($allRoles as $role)
                                    {{-- Exclude 'super-admin' from the dropdown --}}
                                    @if ($role == 'super-admin')
                                        @continue
                                    @endif
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" wire:click="cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <div wire:loading wire:target="saveUser" class="spinner-border spinner-border-sm me-1"
                                role="status"></div>
                            {{ $editingUserId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        @else
            {{-- END OF FORM --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>All Users</h4>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by name or email"
                        wire:model.live.debounce.300ms="search">
                </div>
                <button class="btn btn-primary" wire:click="addNew">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>

            <div class="card-body">

                <div class="alert alert-dismissible fade show"
                    style="background-color: #ffe5e5; color: #a94442; border: 1px solid #f5c6cb;">
                    <strong>Note:</strong> The customer must be approved by admin to access the bidding.
                </div>
                <table class="table table-hover text-center align-middle mb-0 table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    @if ($user->is_approved)
                                        <span class="badge text-white bg-success">Approved</span>
                                    @else
                                        <span class="badge text-white bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-edit text-info me-2" style="cursor: pointer;"
                                        wire:click="editItem({{ $user->id }})" title="Edit"></i>

                                    <i class="fas fa-trash text-danger" style="cursor: pointer;"
                                        wire:click="deleteItem({{ $user->id }})" wire:confirm title="Delete"></i>


                                    @if ($user->is_approved)
                                        <i class="fas fa-times-circle text-danger ms-2"
                                            style="cursor:
                                        pointer;"
                                            wire:confirm wire:click="toggleApproval({{ $user->id }})"
                                            title="Disapprove"></i>
                                    @else
                                        <i class="fas fa-check-circle text-success ms-2"
                                            style="cursor:
                                        pointer;"
                                            wire:confirm wire:click="toggleApproval({{ $user->id }})"
                                            title="Approve"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- ... --}}
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
    </div>
    @endif

    {{-- SweetAlert script remains unchanged --}}
    @push('scripts')
        <script>
            // ... your sweetalert script is perfect as is ...
        </script>
    @endpush
</div>
