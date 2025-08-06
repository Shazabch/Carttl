<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Manage Vehicle Documents</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $item)
                    <tr>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ asset('storage/' .$item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Download PDF"> <i class="fas fa-file-pdf"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>