<div>

    @if (!$isEditable)
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4>Testimonials</h4>
                    <div class="btn btn-primary" wire:click="toggleEditable">
                        Add New
                    </div>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-sm table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Rank</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allTestimonials as $item)
                            <tr>
                                <td>{{ $loop->index() }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->rank }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->comment }}</td>
                                <td>
                                    <i class="fas fa-edit text-primary"></i>
                                    <i class="fas fa-trash text-danger"></i>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4>{{ $testimonial->exists ? 'Edit' : 'Add New' }} Testimonial</h4>
                    <div class="btn btn-primary" wire:click="toggleEditable">
                        Back
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="save()">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('testimonial.name') is-invalid @enderror"
                                wire:model="testimonial.name">
                            @error('testimonial.name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="rank">Rank</label>
                            <input type="text" class="form-control @error('testimonial.rank') is-invalid @enderror"
                                wire:model="testimonial.rank">
                            @error('testimonial.rank')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status">Status</label>
                            <select class="form-control @error('testimonial.status') is-invalid @enderror">
                                <option value="true">Active</option>
                                <option value="false">Archived</option>
                            </select>
                            @error('testimonial.status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="comments">Comment</label>
                            <textarea class="form-control" wire:model="testimonial.comment"></textarea>
                            @error('testimonial.comment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ $testimonial->exists ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
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

            Livewire.on('success-notification', (event) => {
                Swal.fire({
                    title: 'Success!',
                    text: event.message,
                    icon: 'success',
                });
            });
        });
    </script>
@endpush
