<div>


    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($showForm)
    {{-- ======================================================= --}}
    {{-- STATE 1: THE WIZARD FORM (CREATE/EDIT)        --}}
    {{-- ======================================================= --}}

    @include('livewire.admin.inspection.wizard-form')

    @elseif($showDetails)
    {{-- ======================================================= --}}
    {{-- STATE 2: THE DETAILED REPORT VIEW           --}}
    {{-- ======================================================= --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Inspection Report Details</h4>
                <p class="mb-0 text-muted">Report ID: {{ $reportInView->id }}</p>
            </div>
            <div>
                {{-- This button now calls a Livewire action --}}
                <button wire:click="generatePdf({{ $reportInView->id }})" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </button>
                <button wire:click="cancel" class="btn btn-secondary">Back to List</button>
            </div>
        </div>
        <div class="card-body">
            {{-- Reuse the same PDF template for the view content --}}
            @include('admin.inspection.report-pdf-template', ['report' => $reportInView])
        </div>
    </div>

    @else
    {{-- ======================================================= --}}
    {{-- STATE 3: THE LIST OF ALL REPORTS          --}}
    {{-- ======================================================= --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Inspection Reports</h4>
            <button wire:click="showCreateForm" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Report
            </button>
        </div>
        <div class="card-body">
            {{-- Search input --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by VIN or Make...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Make & Model</th>
                            <th>VIN</th>
                            <th>Inspected At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->make }} {{ $report->model }}</td>
                            <td>{{ $report->vin }}</td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                                {{-- This button now calls a Livewire action --}}
                                <button wire:click="showReportDetails({{ $report->id }})" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="generatePdf({{ $report->id }})" class="btn btn-sm btn-outline-danger" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                                <button wire:click="showEditForm({{ $report->id }})" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteReport({{ $report->id }})"
                                    wire:confirm="Are you sure?"
                                    class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>{{ $reports->links() }}</div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        // Listen for the 'livewire:initialized' event to ensure Livewire is ready
        document.addEventListener('livewire:initialized', () => {
            // Listen for the 'confirmDelete' event dispatched from the delete icon
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
                    // If the user confirms, dispatch another event to the component to trigger the deletion
                    if (result.isConfirmed) {
                        @this.dispatch('deleteReport', {
                            id: id
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</div>