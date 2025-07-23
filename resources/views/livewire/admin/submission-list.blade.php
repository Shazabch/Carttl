<div>
    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- <h5 class="mb-0">All Submissions</h5> -->
            <input type="text" class="form-control w-25" placeholder="Search by name or email..." wire:model.live.debounce.300ms="search">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" wire:click="setSortBy('first_name')" style="cursor: pointer;">
                                Name <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('email')" style="cursor: pointer;">
                                Email <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col" wire:click="setSortBy('created_at')" style="cursor: pointer;">
                                Received <i class="fas fa-sort"></i>
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission)
                            <tr wire:key="{{ $submission->id }}">
                                <td>{{ $submission->first_name }} {{ $submission->last_name }}</td>
                                <td>{{ $submission->email }}</td>
                                <td>{{ $submission->created_at->format('M d, Y H:i A') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" wire:click="view({{ $submission->id }})">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-danger"

                                            wire:click="$dispatch('confirmDeleteUser', { id: {{ $submission->id }} })"
                                           >
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $submissions->links() }}
        </div>
    </div>

    {{-- View Submission Modal --}}
    @if ($showModal && isset($selectedSubmission))
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submission from {{ $selectedSubmission->first_name }} {{ $selectedSubmission->last_name }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <strong>Received:</strong>
                            <p>{{ $selectedSubmission->created_at->format('F j, Y, g:i a') }} ({{ $selectedSubmission->created_at->diffForHumans() }})</p>
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong>
                            <p><a href="mailto:{{ $selectedSubmission->email }}">{{ $selectedSubmission->email }}</a></p>
                        </div>
                        @if($selectedSubmission->phone)
                        <div class="mb-3">
                            <strong>Phone:</strong>
                            <p>{{ $selectedSubmission->phone }}</p>
                        </div>
                        @endif
                        <hr>
                        <div class="mb-3">
                            <strong>Message:</strong>
                            <div class="p-3 bg-light border rounded" style="white-space: pre-wrap;">{{ $selectedSubmission->message }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Backdrop --}}
        <div class="modal-backdrop fade show"></div>
    @endif
    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                // Event listener for delete confirmation
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
                           @this.delete(event.id);
                        }
                    });
                });

            });
        </script>
    @endpush
</div>